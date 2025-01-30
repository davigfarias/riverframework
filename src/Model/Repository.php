<?php

namespace Src\Model;

/**
 * @author Dave Farias (davegfarias@gmail.com)
 * @package Src;
 */

abstract class Repository
{
    protected bool $fail = false;
    protected static $dbConnection;
    protected string $msg;

    protected static function initConnection(): void
    {
        if (self::$dbConnection === null)
        {
            self::$dbConnection = require __DIR__.'/../../config/doctrine/config.php';
        };
    }

    protected function fail(): ?bool
    {
        return $this->fail;
    }

    protected function message(): ?string
    {
        return $this->msg;
    }

    protected function create(string $table, array $data): void
    {
        self::initConnection();

        try {
            $create = self::$dbConnection->createQueryBuilder();
            $create->insert($table);

            $platform = self::$dbConnection->getDatabasePlatform();

            foreach ($data as $column => $value) {
        
                $quotedColumn = $platform->quoteIdentifier($column);
                $create->setValue($quotedColumn, ':' . $column);
                $create->setParameter($column, $value);
            }


            $sql = $create->getSQL();
            $params = $create->getParameters();

            $this->logQuery($sql, $params);

          
            $affectedRows = $create->executeStatement();

            if ($affectedRows === 0) {
                $this->logError('Nenhuma linha foi inserida.');
            }

        } catch (\Doctrine\DBAL\Exception $e) {
            
            $this->logError($e->getMessage());
            throw $e;
        }
    }

    protected function read(string $select, string $from, $joins = null, string $aliasFrom = null, mixed $where = null, string $orderBy = null, string $groupBy = null, int $limit = null, int $offset = null, string $package = 'array'): array|\stdClass|null
    {
        try {
            self::initConnection();

            $query = self::$dbConnection->createQueryBuilder()
                ->select($select);
           
            if ($aliasFrom) {
                $query->from($from, $aliasFrom);
                $fromAlias = $aliasFrom;
            } else {
                $query->from($from);
                $fromAlias = $from;
            }

            if ($joins) {
                if (array_keys($joins) !== range(0, count($joins) - 1)) {
                    $joins = [$joins];
                }

                foreach ($joins as $join) {
                    if (isset($join['type'], $join['joinTo'], $join['aliasJoin'], $join['condition'])) {
                        switch (strtolower($join['type'])) {
                            case 'inner':
                                $query->join(
                                    $fromAlias,
                                    $join['joinTo'],
                                    $join['aliasJoin'],
                                    $join['condition']
                                );
                                break;
                            case 'left':
                                $query->leftJoin(
                                    $fromAlias,
                                    $join['joinTo'],
                                    $join['aliasJoin'],
                                    $join['condition']
                                );
                                break;
                            case 'right':
                                $query->rightJoin(
                                    $fromAlias,
                                    $join['joinTo'],
                                    $join['aliasJoin'],
                                    $join['condition']
                                );
                                break;
                            default:
                                throw new \InvalidArgumentException("Tipo de join inválido: '{$join['type']}'. Use 'inner', 'left' ou 'right'.");
                        }
                    } else {
                        throw new \InvalidArgumentException("Parâmetros de join incompletos. Certifique-se de que 'type', 'joinTo', 'aliasJoin' e 'condition' estejam definidos.");
                    }
                }
            }

            $parameters = [];

            if ($where) {
                if (is_string($where)) {
                    foreach (explode(',', $where) as $param) {
                        $param = trim($param);

                        if (preg_match('/^(.+?)(=|LIKE|!=|<>)\s*(.+)$/i', $param, $matches)) {
                            list(, $column, $operator, $value) = $matches;
                        
                            $column = trim($column);
                            $operator = strtoupper(trim($operator));
                            $value = trim($value, "'\""); 
                        
                            $parameters[] = [
                                'column' => $column,
                                'operator' => $operator,
                                'value' => $value
                            ];
                        } else {
                            throw new \InvalidArgumentException("Parâmetro inválido: '$param'. Use o formato 'chave = valor', 'chave != valor' ou 'chave LIKE valor'.");
                        }
                    }
                } elseif (is_array($where)) {
                    foreach ($where as $key => $value) {
                        $parts = preg_split('/\s+/', trim($key), 2);
                        $column = $parts[0];
                        $operator = isset($parts[1]) ? strtoupper($parts[1]) : '=';

                        if (!in_array($operator, ['=', 'LIKE', '!=', '<>'])) {
                            throw new \InvalidArgumentException("Operador inválido: '$operator'. Use '=', '!=', '<>' ou 'LIKE'.");
                        }

                        $parameters[] = [
                            'column' => $column,
                            'operator' => $operator,                            
                            'value' => $value
                        ];
                    }

                    $parameters = array_filter($parameters, fn($param) => $param['value'] !== '');
                }
            }

            foreach ($parameters as $param) {
                $columnName = $param['column'];
                $operator = $param['operator'];
                $value = $param['value'];
            
                $parameterName = str_replace(['.', ' '], '', $columnName) . '' . uniqid();
            
                if ($operator === '=') {
                    $query->andWhere("$columnName = :$parameterName");
                } elseif ($operator === 'LIKE') {
                    $query->andWhere("$columnName LIKE :$parameterName");
                } elseif ($operator === '!=') {
                    $query->andWhere("$columnName != :$parameterName"); 
                } elseif($operator === '<>') {
                    $query->andWhere("$columnName <> :$parameterName"); 
                }
            
                $query->setParameter($parameterName, $value);
            }

            if ($orderBy) {
                if (preg_match('/\s+(ASC|DESC)$/i', $orderBy, $matches)) {
                    $direction = strtoupper($matches[1]);
            
                    $column = preg_replace('/\s+(ASC|DESC)$/i', '', $orderBy);
            
                    $query->orderBy($column, $direction);
                } else {
                    $query->orderBy($orderBy);
                }
            }

            if ($groupBy) {
                $query->groupBy($groupBy);
            }

            if ($limit) {
                if (!is_int($limit) || $limit < 0) {
                    throw new \InvalidArgumentException("O parâmetro 'limit' deve ser um inteiro não negativo.");
                }
                $query->setMaxResults($limit);
            }

            if ($offset) {
                if (!is_int($offset) || $offset < 0) {
                    throw new \InvalidArgumentException("O parâmetro 'offset' deve ser um inteiro não negativo.");
                }
                $query->setFirstResult($offset);
            }

            $sql = $query->getSQL();
            $params = $query->getParameters();

            $this->logQuery($sql, $params);

            $stmt = $query->executeQuery();
            $results = $stmt->fetchAllAssociative();

            if($package === 'array')
            {
                return $results;     
            }
    
            if($package === 'object')
            {
                return Objectification::transform($results);
            }
    
            throw new \InvalidArgumentException("O parâmetro 'package' deve ser 'array' ou 'object'.");

        } catch (\Doctrine\DBAL\Exception $e) {
            $this->fail = false;
            return null;
        }
    }
    
    protected function update(string $table, array $data, array $where): void
    {
        self::initConnection();

        try {
            $update = self::$dbConnection->createQueryBuilder();
            $update->update($table);

    
            foreach ($data as $column => $value) {
                $update->set($column, ':set_' . $column)
                    ->setParameter('set_' . $column, $value);
            }
          
            foreach ($where as $column => $condition) {
                $parameterName = 'where_' . $column;

                if (is_array($condition) && isset($condition['type'], $condition['value'])) {
                    $type = strtoupper($condition['type']);
                    $value = $condition['value'];
                } else {
                    $type = '=';
                    $value = $condition;
                }

               
                if (!in_array($type, ['=', 'LIKE'])) {
                    throw new \InvalidArgumentException("Tipo '$type' não suportado.");
                }
                $update->andWhere("$column $type :$parameterName")
                    ->setParameter($parameterName, $value);
            }

            
            $sql = $update->getSQL();
            $params = $update->getParameters();

            $this->logQuery($sql, $params);

            $affectedRows = $update->executeStatement();

           
            if ($affectedRows === 0) {
                $this->logError('Nenhuma linha foi afetada pela atualização.');
            }

        } catch (\Throwable $e) {
            $this->fail = true;
        
            $this->logError($e->getMessage());
            throw $e;
        }
    }

    private function trash (string $from, array $where = null, $allowDeleteAll = false): void
    {
        self::initConnection();

        try {
            $delete = self::$dbConnection->createQueryBuilder();
            $delete->delete($from);

            if(empty($where))
            {
                if(!$allowDeleteAll)
                {
                    throw new \InvalidArgumentException("Exclude all registers require explicit confirmation");
                }
            } else {
                foreach($where as $column => $condition)
                {
                    $parameterName = 'where_'. $column;

                    if(is_array($condition) && isset($condition['type'], $condition['value']))
                    {
                        $type = stroupper($condition['type']);
                        $value = $condition['value'];
                    } else {
                        $type = '=';
                        $value = $condition;       
                    }

                    if(!in_array($type, ['=', 'LIKE']))
                    {
                        throw new \InvalidArgumentException("Type '$type' is currently not supported");
                    }

                    $delete->andWhere("$column $type :$parameterName")
                    ->setParameter($parameterName, $value);
                }
            }

            $sql = $delete->getSQL();
            $params = $delete->getParameter();

            $this->logQuery($sql, $params);

            $affectedRows = $delete->executeStatement();

            if($affectedRows === 0)
            {
                $this->logError("No lines affected");
            }

        } catch (\Throwable $th) {
            $this->fail = true;
            $this->logError($e->getMessage());
            throw $e;
        }
    }

    private function logQuery(string $sql, array $params): void
    {
        $logFile = _DIR_ . '/logs/queries.log';

        if (!is_dir(dirname($logFile))) {
            mkdir(dirname($logFile), 0777, true);
        }

        $interpolatedQuery = $this->interpolateQuery($sql, $params);

        $logMessage = '[' . date('Y-m-d H:i:s') . '] SQL: ' . $interpolatedQuery . PHP_EOL;

        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }



    private function logError(string $errorMessage): void
    {
        $logFile = _DIR_ . '/logs/errors.log'; 

        if (!is_dir(dirname($logFile))) {
            mkdir(dirname($logFile), 0777, true);
        }

        $logMessage = '[' . date('Y-m-d H:i:s') . '] Error: ' . $errorMessage . PHP_EOL;

        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    private function interpolateQuery(string $sql, array $params): string
    {
        uksort($params, function($a, $b) {
            return strlen($b) - strlen($a);
        });

        foreach ($params as $key => $value) {
            $placeholder = ':' . $key;

            if (is_null($value)) {
                $replacement = 'NULL';
            } elseif (is_numeric($value)) {
                $replacement = $value;
            } else {
                $replacement = "'" . addslashes($value) . "'";
            }

            $sql = str_replace($placeholder, $replacement, $sql);
        }

        return $sql;
    }
}