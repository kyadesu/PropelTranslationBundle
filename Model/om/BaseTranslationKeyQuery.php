<?php

namespace Propel\TranslationBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Etf1Cms\CoreBundle\Model\Core\Menu;
use Propel\TranslationBundle\Model\TranslationContent;
use Propel\TranslationBundle\Model\TranslationKey;
use Propel\TranslationBundle\Model\TranslationKeyPeer;
use Propel\TranslationBundle\Model\TranslationKeyQuery;

/**
 * @method TranslationKeyQuery orderById($order = Criteria::ASC) Order by the id column
 * @method TranslationKeyQuery orderByKeyName($order = Criteria::ASC) Order by the key_name column
 * @method TranslationKeyQuery orderByDomain($order = Criteria::ASC) Order by the domain column
 * @method TranslationKeyQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method TranslationKeyQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method TranslationKeyQuery groupById() Group by the id column
 * @method TranslationKeyQuery groupByKeyName() Group by the key_name column
 * @method TranslationKeyQuery groupByDomain() Group by the domain column
 * @method TranslationKeyQuery groupByCreatedAt() Group by the created_at column
 * @method TranslationKeyQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method TranslationKeyQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method TranslationKeyQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method TranslationKeyQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method TranslationKeyQuery leftJoinMenu($relationAlias = null) Adds a LEFT JOIN clause to the query using the Menu relation
 * @method TranslationKeyQuery rightJoinMenu($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Menu relation
 * @method TranslationKeyQuery innerJoinMenu($relationAlias = null) Adds a INNER JOIN clause to the query using the Menu relation
 *
 * @method TranslationKeyQuery leftJoinTranslationContent($relationAlias = null) Adds a LEFT JOIN clause to the query using the TranslationContent relation
 * @method TranslationKeyQuery rightJoinTranslationContent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TranslationContent relation
 * @method TranslationKeyQuery innerJoinTranslationContent($relationAlias = null) Adds a INNER JOIN clause to the query using the TranslationContent relation
 *
 * @method TranslationKey findOne(PropelPDO $con = null) Return the first TranslationKey matching the query
 * @method TranslationKey findOneOrCreate(PropelPDO $con = null) Return the first TranslationKey matching the query, or a new TranslationKey object populated from the query conditions when no match is found
 *
 * @method TranslationKey findOneById(int $id) Return the first TranslationKey filtered by the id column
 * @method TranslationKey findOneByKeyName(string $key_name) Return the first TranslationKey filtered by the key_name column
 * @method TranslationKey findOneByDomain(string $domain) Return the first TranslationKey filtered by the domain column
 * @method TranslationKey findOneByCreatedAt(string $created_at) Return the first TranslationKey filtered by the created_at column
 * @method TranslationKey findOneByUpdatedAt(string $updated_at) Return the first TranslationKey filtered by the updated_at column
 *
 * @method array findById(int $id) Return TranslationKey objects filtered by the id column
 * @method array findByKeyName(string $key_name) Return TranslationKey objects filtered by the key_name column
 * @method array findByDomain(string $domain) Return TranslationKey objects filtered by the domain column
 * @method array findByCreatedAt(string $created_at) Return TranslationKey objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return TranslationKey objects filtered by the updated_at column
 */
abstract class BaseTranslationKeyQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseTranslationKeyQuery object.
     *
     * @param string $dbName     The dabase name
     * @param string $modelName  The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'Propel\\TranslationBundle\\Model\\TranslationKey', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new TranslationKeyQuery object.
     *
     * @param string                       $modelAlias The alias of a model in the query
     * @param TranslationKeyQuery|Criteria $criteria   Optional Criteria to build the query from
     *
     * @return TranslationKeyQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof TranslationKeyQuery) {
            return $criteria;
        }
        $query = new TranslationKeyQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
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
     * @param mixed     $key Primary key to use for the query
     * @param PropelPDO $con an optional connection object
     *
     * @return TranslationKey|TranslationKey[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TranslationKeyPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(TranslationKeyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @param mixed     $key Primary key to use for the query
     * @param PropelPDO $con A connection object
     *
     * @return TranslationKey  A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `KEY_NAME`, `DOMAIN`, `CREATED_AT`, `UPDATED_AT` FROM `translation_key` WHERE `ID` = :p0';
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
            $obj = new TranslationKey();
            $obj->hydrate($row);
            TranslationKeyPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed     $key Primary key to use for the query
     * @param PropelPDO $con A connection object
     *
     * @return TranslationKey|TranslationKey[]|mixed the result, formatted by the current formatter
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
     * @param array     $keys Primary keys to use for the query
     * @param PropelPDO $con  an optional connection object
     *
     * @return PropelObjectCollection|TranslationKey[]|mixed the list of results, formatted by the current formatter
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
     * @param mixed $key Primary key to use for the query
     *
     * @return TranslationKeyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TranslationKeyPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array $keys The list of primary key to use for the query
     *
     * @return TranslationKeyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TranslationKeyPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TranslationKeyQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(TranslationKeyPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the key_name column
     *
     * Example usage:
     * <code>
     * $query->filterByKeyName('fooValue');   // WHERE key_name = 'fooValue'
     * $query->filterByKeyName('%fooValue%'); // WHERE key_name LIKE '%fooValue%'
     * </code>
     *
     * @param string $keyName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TranslationKeyQuery The current query, for fluid interface
     */
    public function filterByKeyName($keyName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($keyName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $keyName)) {
                $keyName = str_replace('*', '%', $keyName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TranslationKeyPeer::KEY_NAME, $keyName, $comparison);
    }

    /**
     * Filter the query on the domain column
     *
     * Example usage:
     * <code>
     * $query->filterByDomain('fooValue');   // WHERE domain = 'fooValue'
     * $query->filterByDomain('%fooValue%'); // WHERE domain LIKE '%fooValue%'
     * </code>
     *
     * @param string $domain The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TranslationKeyQuery The current query, for fluid interface
     */
    public function filterByDomain($domain = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($domain)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $domain)) {
                $domain = str_replace('*', '%', $domain);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TranslationKeyPeer::DOMAIN, $domain, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TranslationKeyQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(TranslationKeyPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(TranslationKeyPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationKeyPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TranslationKeyQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(TranslationKeyPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(TranslationKeyPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationKeyPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related Menu object
     *
     * @param Menu|PropelObjectCollection $menu       the related object to use as filter
     * @param string                      $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TranslationKeyQuery The current query, for fluid interface
     * @throws PropelException     - if the provided filter is invalid.
     */
    public function filterByMenu($menu, $comparison = null)
    {
        if ($menu instanceof Menu) {
            return $this
                ->addUsingAlias(TranslationKeyPeer::ID, $menu->getTranslationKeyId(), $comparison);
        } elseif ($menu instanceof PropelObjectCollection) {
            return $this
                ->useMenuQuery()
                ->filterByPrimaryKeys($menu->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMenu() only accepts arguments of type Menu or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Menu relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TranslationKeyQuery The current query, for fluid interface
     */
    public function joinMenu($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Menu');

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
            $this->addJoinObject($join, 'Menu');
        }

        return $this;
    }

    /**
     * Use the Menu relation Menu object
     *
     * @see       useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Etf1Cms\CoreBundle\Model\Core\MenuQuery A secondary query class using the current class as primary query
     */
    public function useMenuQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMenu($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Menu', '\Etf1Cms\CoreBundle\Model\Core\MenuQuery');
    }

    /**
     * Filter the query by a related TranslationContent object
     *
     * @param TranslationContent|PropelObjectCollection $translationContent the related object to use as filter
     * @param string                                    $comparison         Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TranslationKeyQuery The current query, for fluid interface
     * @throws PropelException     - if the provided filter is invalid.
     */
    public function filterByTranslationContent($translationContent, $comparison = null)
    {
        if ($translationContent instanceof TranslationContent) {
            return $this
                ->addUsingAlias(TranslationKeyPeer::ID, $translationContent->getKeyId(), $comparison);
        } elseif ($translationContent instanceof PropelObjectCollection) {
            return $this
                ->useTranslationContentQuery()
                ->filterByPrimaryKeys($translationContent->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTranslationContent() only accepts arguments of type TranslationContent or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TranslationContent relation
     *
     * @param string $relationAlias optional alias for the relation
     * @param string $joinType      Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TranslationKeyQuery The current query, for fluid interface
     */
    public function joinTranslationContent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TranslationContent');

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
            $this->addJoinObject($join, 'TranslationContent');
        }

        return $this;
    }

    /**
     * Use the TranslationContent relation TranslationContent object
     *
     * @see       useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\TranslationBundle\Model\TranslationContentQuery A secondary query class using the current class as primary query
     */
    public function useTranslationContentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTranslationContent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TranslationContent', '\Propel\TranslationBundle\Model\TranslationContentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param TranslationKey $translationKey Object to remove from the list of results
     *
     * @return TranslationKeyQuery The current query, for fluid interface
     */
    public function prune($translationKey = null)
    {
        if ($translationKey) {
            $this->addUsingAlias(TranslationKeyPeer::ID, $translationKey->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
