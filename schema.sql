
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(300) NOT NULL,
    `firstname` VARCHAR(300),
    `lastname` VARCHAR(300),
    `pay` VARCHAR(300),
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- products
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `beschr` VARCHAR(400),
    PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- cart
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart`
(
    `userID` INTEGER NOT NULL,
    `productID` INTEGER NOT NULL,
    PRIMARY KEY (`userID`,`productID`),
    INDEX `cart_FI_2` (`productID`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
