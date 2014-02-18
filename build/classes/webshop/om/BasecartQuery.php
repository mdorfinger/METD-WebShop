<?php


/**
 * Base class that represents a query for the 'cart' table.
 *
 *
 *
 * @method cartQuery orderByUserid($order = Criteria::ASC) Order by the userID column
 * @method cartQuery orderByProductid($order = Criteria::ASC) Order by the productID column
 *
 * @method cartQuery groupByUserid() Group by the userID column
 * @method cartQuery groupByProductid() Group by the productID column
 *
 * @method cartQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method cartQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method cartQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method cartQuery leftJoinuser($relationAlias = null) Adds a LEFT JOIN clause to the query using the user relation
 * @method cartQuery rightJoinuser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the user relation
 * @method cartQuery innerJoinuser($relationAlias = null) Adds a INNER JOIN clause to the query using the user relation
 *
 * @method cartQuery leftJoinproducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the products relation
 * @method cartQuery rightJoinproducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the products relation
 * @method cartQuery innerJoinproducts($relationAlias = null) Adds a INNER JOIN clause to the query using the products relation
 *
 * @method cart findOne(PropelPDO $con = null) Return the first cart matching the query
 * @method cart findOneOrCreate(PropelPDO $con = null) Return the first cart matching the query, or a new cart object populated from the query conditions when no match is found
 *
 * @method cart findOneByUserid(int $userID) Return the first cart filtered by the userID column
 * @method cart findOneByProductid(int $productID) Return the first cart filtered by the productID column
 *
 * @method array findByUserid(int $userID) Return cart objects filtered by the userID column
 * @method array findByProductid(int $productID) Return cart objects filtered by the productID column
 *
 * @package    propel.generator.webshop.om
 */
abstract class BasecartQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BasecartQuery object.
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
            $modelName = 'cart';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new cartQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   cartQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return cartQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof cartQuery) {
            return $criteria;
        }
        $query = new cartQuery(null, null, $modelAlias);

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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array $key Primary key to use for the query
                         A Primary key composition: [$userID, $productID]
     * @param     PropelPDO $con an optional connection object
     *
     * @return   cart|cart[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = cartPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(cartPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 cart A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `userID`, `productID` FROM `cart` WHERE `userID` = :p0 AND `productID` = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new cart();
            $obj->hydrate($row);
            cartPeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return cart|cart[]|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|cart[]|mixed the list of results, formatted by the current formatter
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
     * @return cartQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(cartPeer::USERID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(cartPeer::PRODUCTID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return cartQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(cartPeer::USERID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(cartPeer::PRODUCTID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the userID column
     *
     * Example usage:
     * <code>
     * $query->filterByUserid(1234); // WHERE userID = 1234
     * $query->filterByUserid(array(12, 34)); // WHERE userID IN (12, 34)
     * $query->filterByUserid(array('min' => 12)); // WHERE userID >= 12
     * $query->filterByUserid(array('max' => 12)); // WHERE userID <= 12
     * </code>
     *
     * @see       filterByuser()
     *
     * @param     mixed $userid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return cartQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(cartPeer::USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(cartPeer::USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(cartPeer::USERID, $userid, $comparison);
    }

    /**
     * Filter the query on the productID column
     *
     * Example usage:
     * <code>
     * $query->filterByProductid(1234); // WHERE productID = 1234
     * $query->filterByProductid(array(12, 34)); // WHERE productID IN (12, 34)
     * $query->filterByProductid(array('min' => 12)); // WHERE productID >= 12
     * $query->filterByProductid(array('max' => 12)); // WHERE productID <= 12
     * </code>
     *
     * @see       filterByproducts()
     *
     * @param     mixed $productid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return cartQuery The current query, for fluid interface
     */
    public function filterByProductid($productid = null, $comparison = null)
    {
        if (is_array($productid)) {
            $useMinMax = false;
            if (isset($productid['min'])) {
                $this->addUsingAlias(cartPeer::PRODUCTID, $productid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productid['max'])) {
                $this->addUsingAlias(cartPeer::PRODUCTID, $productid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(cartPeer::PRODUCTID, $productid, $comparison);
    }

    /**
     * Filter the query by a related user object
     *
     * @param   user|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 cartQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByuser($user, $comparison = null)
    {
        if ($user instanceof user) {
            return $this
                ->addUsingAlias(cartPeer::USERID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(cartPeer::USERID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByuser() only accepts arguments of type user or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the user relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return cartQuery The current query, for fluid interface
     */
    public function joinuser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('user');

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
            $this->addJoinObject($join, 'user');
        }

        return $this;
    }

    /**
     * Use the user relation user object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   userQuery A secondary query class using the current class as primary query
     */
    public function useuserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinuser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'user', 'userQuery');
    }

    /**
     * Filter the query by a related products object
     *
     * @param   products|PropelObjectCollection $products The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 cartQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByproducts($products, $comparison = null)
    {
        if ($products instanceof products) {
            return $this
                ->addUsingAlias(cartPeer::PRODUCTID, $products->getId(), $comparison);
        } elseif ($products instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(cartPeer::PRODUCTID, $products->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByproducts() only accepts arguments of type products or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the products relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return cartQuery The current query, for fluid interface
     */
    public function joinproducts($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('products');

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
            $this->addJoinObject($join, 'products');
        }

        return $this;
    }

    /**
     * Use the products relation products object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   productsQuery A secondary query class using the current class as primary query
     */
    public function useproductsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinproducts($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'products', 'productsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   cart $cart Object to remove from the list of results
     *
     * @return cartQuery The current query, for fluid interface
     */
    public function prune($cart = null)
    {
        if ($cart) {
            $this->addCond('pruneCond0', $this->getAliasedColName(cartPeer::USERID), $cart->getUserid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(cartPeer::PRODUCTID), $cart->getProductid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

}
