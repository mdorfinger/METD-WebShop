<?php



/**
 * This class defines the structure of the 'cart' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.webshop.map
 */
class cartTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'webshop.map.cartTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('cart');
        $this->setPhpName('cart');
        $this->setClassname('cart');
        $this->setPackage('webshop');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('userID', 'Userid', 'INTEGER' , 'user', 'id', true, null, null);
        $this->addForeignPrimaryKey('productID', 'Productid', 'INTEGER' , 'products', 'id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('user', 'user', RelationMap::MANY_TO_ONE, array('userID' => 'id', ), null, null);
        $this->addRelation('products', 'products', RelationMap::MANY_TO_ONE, array('productID' => 'id', ), null, null);
    } // buildRelations()

} // cartTableMap
