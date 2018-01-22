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
	/**
	 * id for this article; this is the primary key
	 * @var Uuid $articleId
	 */
	private $articleId;
	/**
	 * id of the Profile that published this article; this is the foreign key
	 * @var Uuid $articleProfileId
	 */
	private $articleProfileId;
	/**
	 * this is the article content; mine is set to 5000 characters
	 * @var string $articleContent
	 */
	private $articleContent;
	/**
	 * date and time the article was published in a PHP date time object
	 * @var \DateTime $articleDate
	 **/
	private $articlePublishDate;
	/**
	 * this is the article title; mine is set to 160 characters
	 * @var string $articleTitle
	 */
	private $articleTitle;
	/**
	 * constructor for this article
	 *
	 * @param string|Uuid $newArticleId id of this article or null if a new article
	 * @param string|Uuid $newArticleProfileId id of the Profile that sent this article
	 * @param string $newArticleContent string containing actual article data
	 * @param \DateTime|string|null $newArticlePublishDate date and time article was sent or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newArticleId, $newArticleProfileId, string $newArticleContent, $newArticlePublishDate = null, string $newArticleTitle) {
		try {
			$this->setArticleId($newArticleId);
			$this->setArticleProfileId($newArticleProfileId);
			$this->setArticleContent($newArticleContent);
			$this->setArticlePublishDate($newArticlePublishDate);
			$this->setArticleTitle($newArticleTitle);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for article id
	 *
	 * @return Uuid value of article id
	 **/
	public function getArticleId(): Uuid {
		return ($this->articleId);
	}
	/**
	 * mutator method for article id
	 *
	 * @param Uuid/string $newArticleId new value of article id
	 * @throws \RangeException if $newArticleId is not positive
	 * @throws \TypeError if $newArticleId is not a uuid or string
	 **/
	public function setArticleId($newArticleId): void {
		try {
			$uuid = self::validateUuid($newArticleId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the tweet id
		$this->articleId = $uuid;
	}
	/**
	 * accessor method for article author's profile id
	 *
	 * @return Uuid value of article author's profile id
	 **/
	public function getArticleProfileId(): Uuid {
		return ($this->articleProfileId);
	}
	/**
	 * mutator method for article author's profile id
	 *
	 * @param string | Uuid $newArticleProfileId new value of article author's profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newTweetProfileId is not an integer
	 **/
	public function setArticleProfileId($newArticleProfileId): void {
		try {
			$uuid = self::validateUuid($newArticleProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->articleProfileId = $uuid;
	}
	/**
	 * accessor method for article content
	 *
	 * @return string value of aricle content
	 **/
	public function getArticleContent(): string {
		return ($this->articleContent);
	}
	/**
	 * mutator method for article content
	 *
	 * @param string $newArticleContent new value of article content
	 * @throws \InvalidArgumentException if $enwArticleContent is not a string or insecure
	 * @throws \RangeException if $newArticleContent is > 5000 characters
	 * @throws \TypeError if $newArticleContent is not a string
	 **/
	public function setArticleContent(string $newArticleContent): void {
		// verify the article content is secure
		$newArticleContent = trim($newArticleContent);
		$newArticleContent = filter_var($newArticleContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newArticleContent) === true) {
			throw(new \InvalidArgumentException("article content is empty or insecure"));
		}
		// verify the article content will fit in the database
		if(strlen($newArticleContent) > 5000) {
			throw(new \RangeException("article content too large"));
		}
		// store the article content
		$this->articleContent = $newArticleContent;
	}
	/**
	 * accessor method for article date
	 *
	 * @return \DateTime value of article date
	 **/
	public function getArticlePublishDate(): \DateTime {
		return ($this->articlePublishDateDate);
	}
	/**
	 * mutator method for article date
	 *
	 * @param \DateTime|string|null $newArticlePubllishDate article date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newArticlePublishDate is not a valid object or string
	 * @throws \RangeException if $newArticleDate is a date that does not exist
	 **/
	public function setArticlePublishDate($newArticlePublishDate = null): void {
		// base case: if the date is null, use the current date and time
		if($newArticlePublishDate === null) {
			$this->articlePublishDateDate = new \DateTime();
			return;
		}
		// store the like date using the ValidateDate trait
		try {
			$newArticlePublishDateDate = self::validateDateTime($newArticlePublishDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->articlePublishDateDate = $newArticlePublishDateDate;
	}
	/**
	 * mutator method for article title
	 *
	 * @param string $newArticleTitle new value of article Title
	 * @throws \InvalidArgumentException if $newArticleTitle is not a string or insecure
	 * @throws \RangeException if $newArticleTitle is > 140 characters
	 * @throws \TypeError if $newArticleTitle is not a string
	 **/
	public function setArticleTitle(string $newArticleTitle): void {
		// verify the article title is secure
		$newArticleTitle = trim($newArticleTitle);
		$newArticleTitle = filter_var($newArticleTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newArticleTitle) === true) {
			throw(new \InvalidArgumentException("article title is empty or insecure"));
		}
		// verify the article title will fit in the database
		if(strlen($newArticleTitle) > 140) {
			throw(new \RangeException("title content too large"));
		}
		// store the title content
		$this->articleTitle = $newArticleTitle;
	}
}