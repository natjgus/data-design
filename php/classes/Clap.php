<?php
namespace Edu\Cnm\DataDesign;

require_once("autoload.php"); /**this is us, next require is them **/
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 * Cross section of Medium article
 *
 * This is a cross section of what would be stored when a user claps and article
 *
 * @author Nathaniel Gustafson <natjgus@gmail.com>
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 4.0.0
 * @package Edu\Cnm\DataDesign
 **/

class Clap implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/** id of the clap; this is the parent key
	* @var Uuid $clapId
	 */
	private $clapId;

	/** id for the article that was clapped; this is a foreign key
	 * @var Uuid $clapArticleId
	 */
	private $clapArticleId;
	/**
	 * id of the Profile that sent this clap; this is a foreign key
	 * @var Uuid $clapProfilId
	 **/
	private $clapProfileId;
	/**
	 * date and time this clap was sent, in a PHP DateTime object
	 * @var \DateTime $clapDate
	 **/
	private $clapDate;

	/**
	 * accessor method for clap  id
	 *
	 * @return Uuid value of clap  id
	 **/
	public function getClapId() : Uuid{
		return($this->clapId);
	}
	/**
	 * mutator method for clap id
	 *
	 * @param string|Uuid $newClapId new value of clap id
	 * @throws \RangeException if $newClapId is not positive
	 * @throws \TypeError if $newClapId is not an integer
	 **/
	public function setClapId($newClapId) : void {
		try {
			$uuid = self::validateUuid($newClapId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the clap id
		$this->clapId = $uuid;
	}
	/**
	 * accessor method for clap article id
	 *
	 * @return Uuid value of clap article id
	 **/
	public function getClapArticleId() : Uuid {
		return($this->clapArticleId);
	}
	/**
	 * mutator method for clap article id
	 *
	 * @param string|Uuid $newClapArticleId new value of clap article id
	 * @throws \RangeException if $newClapArticleId is not positive
	 * @throws \TypeError if $newClapArticleId is not an integer
	 **/
	public function setClapArticleId($newClapArticleId) : void {
		try {
			$uuid = self::validateUuid($newClapArticleId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->clapArticleId = $uuid;
	}
	/**
	 * accessor method for clap profile id
	 *
	 * @return Uuid value of clap profile id
	 **/
	public function getClapProfileId() : Uuid{
		return($this->clapProfileId);
	}
	/**
	 * mutator method for clap profile id
	 *
	 * @param string|Uuid $newClapProfileId new value of clap profile id
	 * @throws \RangeException if $newClapProfileId is not positive
	 * @throws \TypeError if $newClapProfileId is not an integer
	 **/
	public function setClapProfileId($newClapProfileId) : void {
		try {
			$uuid = self::validateUuid($newClapProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->clapProfileId = $uuid;
	}
	/**
	 * accessor method for clap date
	 *
	 * @return \DateTime value of clap date
	 **/
	public function getClapDate() : \DateTime {
		return($this->clapDate);
	}
	/**
	 * mutator method for clap date
	 *
	 * @param \DateTime|string|null $newClapDate clap date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newClapDate is not a valid object or string
	 * @throws \RangeException if $newClapDate is a date that does not exist
	 **/
	public function setClapDate($newClapDate = null) : void {
		// base case: if the date is null, use the current date and time
		if($newClapDate === null) {
			$this->clapDate = new \DateTime();
			return;
		}
		// store the like date using the ValidateDate trait
		try {
			$newClapDate = self::validateDateTime($newClapDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->clapDate = $newClapDate;
	}
}