<?php
namespace Edu\Cnm\DataDesign;
require_once("autoload.php");
require_once(dirname(__DIR__›) . "autoload.php");
use Ramsey\Uuid\Uuid;
/**
 * Small Cross Section of a Medium Profile
 *This is a small cross section of the services like Medium hold when articles are published. This is the top of the chain with the other classes below it: Article and Clap.
 *
 * @author Nathaniel Gustafson <natjgus@gmail.com>
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 4.0.0
 **/
class Profile{
	private $profileId;
	/**
	 * id of the Profile that published the article
	 * @var Uuid $profileId
	 */
	private $profileFullName;
	/**
	 * token handed out to verify that account is not malicious
	 * @var string $profileActivationToken
	 **/
	private $profileActivationToken;
	/**
	 * @var string $profileCaption
	 **/
	private $profileCaption;
	/**
	 * email associated with this profile; this is a unique index
	 * @var string $profileEmail
	 **/
	private $profileEmail;
	/**
	 * hash for profile password
	 * @var string $profileHash
	 **/
	private $profileHash;
	/**
	 * phone number stored for this profile without "-"
	 * @var string $profilePhone
	 **/
	private $profilePhone;
	/**
	 * salt stored for this profile
	 * @var string $profileSalt
	 **/
	private $profileSalt;
	/**
	 * accessor method for getting profileId
	 *
	 * @return Uuid value for profileId (or null if new profile)
	 **/


	private articleprofileId;

}