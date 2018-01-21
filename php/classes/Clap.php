<?php
namespace Edu\Cnm\DataDesign;

require_once("autoload.php");
require_once(dirname(__DIR__, ) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 * Cross section of Medium article
 *
 * This is a cross section of what would be stored when a user publishes an article. This entity holds the keys to the "Clap" entity.
 *
 *@author Nathaniel Gustafson <natjgus@gmail.com>
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 4.0.0
 * @package Edu\Cnm\DataDesign
 **/

class Article {
	use ValidateDate;
	use ValidateUuid;
}