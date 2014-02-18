<?php


/**
 * Base class that represents a query for the 'user' table.
 *
 *
 *
 * @method userQuery orderById($order = Criteria::ASC) Order by the id column
 * @method userQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method userQuery orderByFirstname($order = Criteria::ASC) Order by the firstname column
 * @method userQuery orderByLastname($order = Criteria::ASC) Order by the lastname column
 * @method userQuery orderByPay($order = Criteria::ASC) Order by the pay column
 *
 * @method userQuery groupById() Group by the id column
 * @method userQuery groupByEmail() Group by the email column
 * @method userQuery groupByFirstname() Group by the firstname column
 * @method userQuery groupByLastname() Group by the lastname column
 * @method userQuery groupByPay() Group by the pay column
 *
 * @method userQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method userQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method userQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method userQuery leftJoincart($relationAlias = null) Adds a LEFT JOIN clause to the query using the cart relation
 * @method userQuery rightJoincart($relationAlias = null) Adds a RIGHT JOIN clause to the query using the cart relation
 * @method userQuery innerJoincart($relationAlias = null) Adds a INNER JOIN clause to the query using the cart relation
 *
 * @method user findOne(PropelPDO $con = null) Return the first user matching the query
 * @method user findOneOrCreate(PropelPDO $con = null) Return the first user matching the query, or a new user object populated from the query conditions when no match is found
 *
 * @method user findOneByEmail(string $email) Return the first user filtered by the email column
 * @method user findOneByFirstname(string $firstname) Return the first user filtered by the firstname column
 * @method user findOneByLastname(string $lastname) Return the first user filtered by the lastname column
 * @method user findOneByPay(string $pay) Return the first user filtered by the pay column
 *
 * @method array findById(int $id) Return user objects filtered by the id column
 * @method array findByEmail(string $email) Return user objects filtered by the email column
 * @method array findByFirstname(string $firstname) Return user objects filtered by the firstname column
 * @method array findByLastname(string $lastname) Return user objects filtered by the lastname column
 * @method array findByPay(string $pay) Return user objects filtered by the pay column
 *
 * @package    propel.generator.webshop.om
 */
abstract class BaseuserQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseuserQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'webshop';
        }
        if (null === $modelName) {
            $modelName = 'user';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new userQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   userQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return userQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof userQuery) {
            return $criteria;
        }
        $query = new userQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   user|user[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = userPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(userPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 user A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 user A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `email`, `firstname`, `lastname`, `pay` FROM `user` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new user();
            $obj->hydrate($row);
            userPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return user|user[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|user[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return userQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(userPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return userQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(userPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return userQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(userPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(userPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(userPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return userQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(userPeer::EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the firstname column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstname('fooValue');   // WHERE firstname = 'fooValue'
     * $query->filterByFirstname('%fooValue%'); // WHERE firstname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return userQuery The current query, for fluid interface
     */
    public function filterByFirstname($firstname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $firstname)) {
                $firstname = str_replace('*', '%', $firstname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(userPeer::FIRSTNAME, $firstname, $comparison);
    }

    /**
     * Filter the query on the lastname column
     *
     * Example usage:
     * <code>
     * $query->filterByLastname('fooValue');   // WHERE lastname = 'fooValue'
     * $query->filterByLastname('%fooValue%'); // WHERE lastname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return userQuery The current query, for fluid interface
     */
    public function filterByLastname($lastname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lastname)) {
                $lastname = str_replace('*', '%', $lastname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(userPeer::LASTNAME, $lastname, $comparison);
    }

    /**
     * Filter the query on the pay column
     *
     * Example usage:
     * <code>
     * $query->filterByPay('fooValue');   // WHERE pay = 'fooValue'
     * $query->filterByPay('%fooValue%'); // WHERE pay LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pay The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return userQuery The current query, for fluid interface
     */
    public function filterByPay($pay = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pay)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pay)) {
                $pay = str_replace('*', '%', $pay);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(userPeer::PAY, $pay, $comparison);
    }

    /**
     * Filter the query by a related cart object
     *
     * @param   cart|PropelObjectCollection $cart  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 userQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBycart($cart, $comparison = null)
    {
        if ($cart instanceof cart) {
            return $this
                ->addUsingAlias(userPeer::ID, $cart->getUserid(), $comparison);
        } elseif ($cart instanceof PropelObjectCollection) {
            return $this
                ->usecartQuery()
                ->filterByPrimaryKeys($cart->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBycart() only accepts arguments of type cart or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the cart relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return userQuery The current query, for fluid interface
     */
    public function joincart($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('cart');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'cart');
        }

        return $this;
    }

    /**
     * Use the cart relation cart object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   cartQuery A secondary query class using the current class as primary query
     */
    public function usecartQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joincart($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'cart', 'cartQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   user $user Object to remove from the list of results
     *
     * @return userQuery The current query, for fluid interface
     */
    public function prune($user = null)
    {
        if ($user) {
            $this->addUsingAlias(userPeer::ID, $user->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
