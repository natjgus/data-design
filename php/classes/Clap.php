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
	public function getClapId(): Uuid {
		return ($this->clapId);
	}

	/**
	 * mutator method for clap id
	 *
	 * @param string|Uuid $newClapId new value of clap id
	 * @throws \RangeException if $newClapId is not positive
	 * @throws \TypeError if $newClapId is not an integer
	 **/
	public function setClapId($newClapId): void {
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
	public function getClapArticleId(): Uuid {
		return ($this->clapArticleId);
	}

	/**
	 * mutator method for clap article id
	 *
	 * @param string|Uuid $newClapArticleId new value of clap article id
	 * @throws \RangeException if $newClapArticleId is not positive
	 * @throws \TypeError if $newClapArticleId is not an integer
	 **/
	public function setClapArticleId($newClapArticleId): void {
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
	public function getClapProfileId(): Uuid {
		return ($this->clapProfileId);
	}

	/**
	 * mutator method for clap profile id
	 *
	 * @param string|Uuid $newClapProfileId new value of clap profile id
	 * @throws \RangeException if $newClapProfileId is not positive
	 * @throws \TypeError if $newClapProfileId is not an integer
	 **/
	public function setClapProfileId($newClapProfileId): void {
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
	public function getClapDate(): \DateTime {
		return ($this->clapDate);
	}

	/**
	 * mutator method for clap date
	 *
	 * @param \DateTime|string|null $newClapDate clap date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newClapDate is not a valid object or string
	 * @throws \RangeException if $newClapDate is a date that does not exist
	 **/
	public function setClapDate($newClapDate = null): void {
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

	/**
	 * inserts this clap into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function insert(\PDO $pdo): void {
		//create query template
		$query = "INSERT INTO clap(clapId, clapArticleId, clapProfileId, clapDate) VALUES(:clapId, :clapArticleId, :clapProfileId, :clapDate)";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$formattedDate = $this->clapDate->format("Y-m-d H:i:s.u");
		$parameters = ["clapId" => $this->clapId->getBytes(), "clapArticleId" => $this->clapArticleId->getBytes(), "clapProfileId" => $this->clapProfileId->getBytes(), "clapDate" => $formattedDate];
		$statement->execute($parameters);

	}

	/**
	 *deletes clap from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function delete(\PDO $pdo): void {
		//create a query template
		$query = "DELETE FROM clap WHERE clapId = :clapId AND clapArticleId = :clapArticleId AND clapProfileId = :clapProfileId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the placeholders in template
		$parameters = ["clapId" => $this->clapId->getBytes(), "clapArticleId" => $this->clapArticleId->getBytes(), "clapProfileId" => $this->clapProfileId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * gets the clap by clap id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string|Uuid $clapProfileId profile id to search for
	 * @return \SplFixedArray SplFixedArray of claps found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public static function getClapByClapId(\PDO $pdo, $clapId) {
		//sanitize the clapId before searching
		try {
			$clapId = self::validateUuid($clapId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create media query template
		$query = "SELECT clapId, clapProfileId, clapArticleId, articleDate FROM clap WHERE clapId = clapId";
		$statement = $pdo->prepare($query);
		//bind the article id to the place holder in the template
		$parameters = ["clapId" => $clapId->getBytes()];
		$statement->execute($parameters);
		// grab the clap from mySQL
		try {
			$clap = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$article = new Article($row["clapId"], $row["clapProfileId"], $row["clapArticleId"], $row["clapDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($clap);
	}

	/**
	 * gets the clap by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string|Uuid $clapProfileId profile id to search for
	 * @return \SplFixedArray SplFixedArray of claps found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public static function getClapByClapProfileId(\PDO $pdo, $clapProfileId): \SPLFixedArray {
		try {
			$clapProfileId = self::validateUuid($clapProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT clapId, clapArticleId, clapProfileId, clapDate FROM clap WHERE clapProfileId = :clapProfileId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["clapProfileId" => $clapProfileId->getBytes()];
		$statement->execute($parameters);
		// build an array of claps
		$claps = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$clap = new Clap($row["clapId"], $row["clapArticleId"], $row["clapProfileId"], $row["clapDate"]);
				$claps[$claps->key()] = $clap;
				$claps->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($claps);
	}

	/**
	 * gets the clap by article id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string|Uuid $clapArticleId article id to search for
	 * @return \SplFixedArray array of Likes found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public static function getClapByClapArticleId(\PDO $pdo, $clapArticleId): \SplFixedArray {
		try {
			$clapArticleId = self::validateUuid($clapArticleId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT clapId, clapArticleId, clapProfileId, clapDate FROM clap WHERE clapArticleId = :clapArticleId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["clapArticleId" => $clapArticleId->getBytes()];
		$statement->execute($parameters);
		// build the array of likes
		$claps = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$clap = new Clap($row["clapId"], $row["clapArticleId"], $row["clapProfileId"], $row["clapDate"]);
				$claps[$claps->key()] = $clap;
				$claps->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($claps);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		$fields["clapId"] = $this->clapId->toString();
		$fields["clapArticleId"] = $this->clapArticleId->toString();
		$fields["clapProfileId"] = $this->clapProfileId->toString();
		$fields["clapDate"] = round(floatval($this->clapDate->format("U.u")) * 1000);
		return ($fields);
	}
}