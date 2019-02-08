<?php
    /**
     * Cette classe sert de mère à tous les modèles, elle permet de gérer l'ensemble des fonction necessaires aux requetes en base de données
     * @param $pdo : Une instance de PDO
     */
    class Model
    {
        //Les variables internes au Model
        var $pdo;

        //Les constantes des différents types de retours possibles
        const NO = 0; //Pas de retour
        const FETCH = 1; //Retour de type fetch
        const FETCHALL = 2; //Retour de type fetchall
        const ROWCOUNT = 3; //Retour de type rowCount()

        /**
         * Model constructor
         * @param PDO $pdo : PDO connect to use
         */
        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        /**
         * Cette fonction permet créer une connexion à une base SQL via PDO
         * @param string $host : L'host à contacter
         * @param string $dbname : Le nom de la base à contacter
         * @param string $user : L'utilisateur à utiliser
         * @param string $password : Le mot de passe à employer
         * @return mixed : Un objet PDO ou false en cas d'erreur
         */
        public static function connect ($host, $dbname, $user, $password, ?string $charset = 'UTF8', ?array $options = null)
        {
            $options = $options ?? [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            
            // On se connecte à MySQL
            $pdo = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=' . $charset , $user, $password, $options);

            if ($pdo === false)
            {
                throw new DescartesExceptionDatabaseConnection('Cannot connect to database ' . $dbname . '.');
            }
                
            return $pdo;
        }

        /**
         * Run a query and return result
         * @param string $query : Query to run
         * @param array $datas : Datas to pass to query
         * @param const $return_type : Type of return, by default all results, see Model constants
         * @param const $fetch_mode : Format of result from db, by default array, FETCH_ASSOC
         * @param boolean $debug : If we must return debug info instead of data, by default false
         * @return mixed : Result of query, depend of $return_type | null | array | object | int
         */
        public function run_query (string $query, array $datas = array(), int $return_type = self::FETCHALL, int $fetch_mode = PDO::FETCH_ASSOC, bool $debug = false)
        {
            $query = $this->pdo->prepare($query);
            $query->setFetchMode($return_type);
            $query->execute($datas);

            if ($debug)
            {
                return $query->errorInfo();
            }

            switch ($return_type)
            {
                case self::NO :
                    $return = NULL;
                    break; 

                case self::FETCH :
                    $return = $query->fetch();
                    break; 

                case self::FETCHALL :
                    $return = $query->fetchAll();
                    break; 
                
                case self::ROWCOUNT : 
                    $return = $query->rowCount();
                    break;
            
                default :
                    $return = $query->fetchAll();
            }

            return $return;
        }
        
        /**
         * Return last inserted id
         * return int : Last inserted id
         */
        public function last_id() : int
        {
            return $this->pdo->lastInsertId();
        }

        /*
            Fonctions d'execution des requetes ou de génération
        */

        
        /**
         * Generate IN query params and values
         * @param string $values : Values to generate in array from
         * @return array : Array ['QUERY' => string 'IN(...)', 'PARAMS' => [parameters to pass to execute]]
        */
        public function generate_in_from_array ($values)
        {
            $return = array(
                'QUERY' => '',
                'PARAMS' => array(),
            );
            
            $flags = array();

            $values = count($values) ? $values : array();
            
            foreach ($values as $clef => $value)
            {
                $return['PARAMS']['in_value_' . $clef] = $value;
                $flags[] = ':in_value_' . $clef;
            }        
                
            $return['QUERY'] .= ' IN(' . implode(', ', $flags) . ')';
            return $return;
        }


        /**
         * Evaluate a condition to generate query string and params array for
         * @param string $fieldname : fieldname possibly preceed by '<, >, <=, >=, ! or ='
         * @param $value : value of field
         * @return array : array with QUERY and PARAMS
         */
        public function evaluate_condition (string $fieldname, $value) : array
        {
            $first_char = mb_substr($fieldname, 0, 1);
            $second_char = mb_substr($fieldname, 1, 1);

            switch(true)
            {
                //Important de traiter <= & >= avant < & >
                case ('<=' == $first_char . $second_char) :
                    $true_fieldname = mb_substr($fieldname, 2);
                    $operator = '<=';
                    break;

                case ('>=' == $first_char . $second_char) :
                    $true_fieldname = mb_substr($fieldname, 2);
                    $operator = '>=';
                    break;

                case ('!=' == $first_char . $second_char) :
                    $true_fieldname = mb_substr($fieldname, 2);
                    $operator = '!=';
                    break;

                case ('!' == $first_char) :
                    $true_fieldname = mb_substr($fieldname, 1);
                    $operator = '!=';
                    break;

                case ('<' == $first_char) :
                    $true_fieldname = mb_substr($fieldname, 1);
                    $operator = '<';
                    break;

                case ('>' == $first_char) :
                    $true_fieldname = mb_substr($fieldname, 1);
                    $operator = '>';
                    break;

                case ('=' == $first_char) :
                    $true_fieldname = mb_substr($fieldname, 1);
                    $operator = '=';
                    break;

                default :
                    $true_fieldname = $fieldname;
                    $operator = '=';
            }

            $query = '`' . $true_fieldname . '` ' . $operator . ' :where_' . $true_fieldname;
            $param = ['where_' . $true_fieldname => $value];

            return ['QUERY' => $query, 'PARAM' => $param];
        }


        /**
         * Get from table, posssibly with some conditions
         * @param string $table : table name
         * @param array $conditions : Where conditions to use, format 'fieldname' => 'value', fieldname can be preceed by operator '<, >, <=, >=, ! or = (by default)' to adapt comparaison operator
         * @param ?string $order_by : name of column to order result by, null by default
         * @param string $desc : L'ordre de tri (asc ou desc). Si non défini, ordre par défaut (ASC)
         * @param string $limit : Le nombre maximum de résultats à récupérer (par défaut pas le limite)
         * @param string $offset : Le nombre de résultats à ignorer (par défaut pas de résultats ignorés)
         * @return mixed : False en cas d'erreur, sinon les lignes retournées
         */
        public function get (string $table, array $conditions = [], ?string $order_by = null, bool $desc = false, ?int $limit = null, ?int $offset = null)
        {
            $wheres = array();
            $params = array();
            foreach ($conditions as $label => $value)
            {
                $condition = $this->evaluate_condition($label, $value);
                $wheres[] = $condition['QUERY'];
                $params = array_merge($params, $condition['PARAM']);
            }

            $query = "SELECT * FROM " . $table . " WHERE 1 " . (count($wheres) ? 'AND ' : '') . implode('AND ', $wheres);

            if ($order_by !== null)
            {
                $query .= ' ORDER BY ' . $order_by;
                
                if ($desc) 
                {
                    $query .= ' DESC';
                }
            }

            if ($limit !== null)
            {
                $query .= ' LIMIT :limit';
                if ($offset !== null)
                {
                    $query .= ' OFFSET :offset';
                }
            }


            $query = $this->pdo->prepare($query);

            if ($limit !== null)
            {
                $query->bindParam(':limit', $limit, PDO::PARAM_INT);
                
                if ($offset !== null)
                {
                    $query->bindParam(':offset', $offset, PDO::PARAM_INT);
                }
            }

            foreach ($params as $label => &$param)
            {
                $query->bindParam(':' . $label, $param);
            }

            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();

            return $query->fetchAll();
        }


        /**
         * Get one line from table, posssibly with some conditions
         * see get
         */
        public function get_one (string $table, array $conditions = [], ?string $order_by = null, bool $desc = false, ?int $limit = null, ?int $offset = null)
        {
            $result = $this->get($table, $conditions, $order_by, $desc, $limit, $offset);

            if (empty($result[0]))
            {
                return $result;
            }

            return $result[0];
        }
        
        /**
         * Count line from table, posssibly with some conditions
         * @param array $conditions : conditions of query Les conditions pour la mise à jour sous la forme "label" => "valeur". Un operateur '<, >, <=, >=, !' peux précder le label pour modifier l'opérateur par défaut (=)
         */
        public function count (string $table, array $conditions = []) : int
        {
            $wheres = array();
            $params = array();
            foreach ($conditions as $label => $value)
            {
                $condition = $this->evaluate_condition($label, $value);
                $wheres[] = $condition['QUERY'];
                $params = array_merge($params, $condition['PARAM']);
            }

            $query = "SELECT COUNT(*) as `count` FROM " . $table . " WHERE 1 " . (count($wheres) ? 'AND ' : '') . implode('AND ', $wheres);
            
            $query = $this->pdo->prepare($query);

            foreach ($params as $label => &$param)
            {
                $query->bindParam(':' . $label, $param);
            }

            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();

            return $query->fetch()['count'];
        }


        /**
         * Update data from table with some conditions
         * @param string $table : table name
         * @param array $datas : new data to set
         * @param array $conditions : conditions of update, Les conditions pour la mise à jour sous la forme "label" => "valeur". Un operateur '<, >, <=, >=, !' peux précder le label pour modifier l'opérateur par défaut (=)
         * @param array $conditions : conditions to use, format 'fieldname' => 'value', fieldname can be preceed by operator '<, >, <=, >=, ! or = (by default)' to adapt comparaison operator
         * @return mixed : Number of line modified
         */
        public function update (string $table, array $datas, array $conditions = array()) : int
        {
            $params = array();
            $sets = array();

            
            foreach ($datas as $label => $value)
            {
                $params['set_' . $label] = $value;
                $sets[] = '`' . $label . '` = :set_' . $label . ' ';
            }


            $wheres = array();
            foreach ($conditions as $label => $value)
            {
                $condition = $this->evaluate_condition($label, $value);
                $wheres[] = $condition['QUERY'];
                $params = array_merge($params, $condition['PARAM']);
            }


            $query = "UPDATE `" . $table . "` SET " . implode(', ', $sets) . " WHERE 1 AND " . implode('AND ', $wheres);
            return $this->run_query($query, $params, self::ROWCOUNT);
        }

        /**
         * Delete from table according to certain conditions
         * @param string $table : Table name
         * @param array $conditions : conditions to use, format 'fieldname' => 'value', fieldname can be preceed by operator '<, >, <=, >=, ! or = (by default)' to adapt comparaison operator
         * @return mixed : Number of line deleted
         */
        public function delete (string $table, array $conditions = []) : int
        {
            //On gère les conditions
            $wheres = array();
            $params = array();
            foreach ($conditions as $label => $value)
            {
                $condition = $this->evaluate_condition($label, $value);
                $wheres[] = $condition['QUERY'];
                $params = array_merge($params, $condition['PARAM']);
            }

            $query = "DELETE FROM `" . $table . "` WHERE 1 AND " . implode('AND ', $wheres);
            return $this->run_query($query, $params, self::ROWCOUNT);
        }

        /**
         * Insert new line into table
         * @param string $table : table name
         * @param array $datas : new datas
         * @return mixed : null on error, number of line inserted else
         */
        public function insert (string $table, array $datas) : ?int
        {
            $params = array();
            $field_names = array();

            foreach ($datas as $field_name => $value)
            {
                $params[$field_name] = $value;
                $field_names[] = $field_name;
            }

            $query = "INSERT INTO `" . $table . "` (`" . implode('`, `', $field_names) . "`) VALUES(:" . implode(', :', $field_names) . ")";

            //On retourne le nombre de lignes insérées
            return $this->run_query($query, $params, self::ROWCOUNT);
        }

    } 
