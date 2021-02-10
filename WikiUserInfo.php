<?php

namespace WikiUserInfo;

use Parser;
use Title;
use User;

class WikiUserInfo {

	/**
	 * @param Parser $parser
	 * @param User $user
	 *
	 * @return string
	 */
	public static function realname( $parser, $user ) {
		$user = self::getUser( $parser, $user );
		if ( !$user->getRealName() ) {
			return $user->getName();
		}
		return $user->getRealName();
	}

	/**
	 * @param Parser $parser
	 * @param User $user
	 *
	 * @return bool|User
	 */
	public static function getUser( $parser, $user ) {
		$title = Title::newFromText( $user );
		if ( is_object( $title ) && $title->getNamespace() == NS_USER ) {
			$user = $title->getText();
		}
		$user = User::newFromName( $user );
		if ( !$user ) {
			global $wgUser;
			$user = $wgUser;
		}
		return $user;
	}

	/**
	 * @param Parser $parser
	 * @param User $user
	 *
	 * @return string|void
	 */
	public static function email( $parser, $user ) {
		global $wgUser, $wgOut;
		if ( !$wgUser->isAllowed( 'showuseremail' ) && !$wgUser->isAllowed( 'lookupuser' ) ) {
			$wgOut->showPermissionsErrorPage( [ 'showuseremail' ] );
			return;
		}
		$user = self::getUser( $parser, $user );
		return $user->getEmail();
	}

	/**
	 * @param Parser $parser
	 * @param User $user
	 *
	 * @return mixed|void|null
	 */
	public static function nickname( $parser, $user ) {
		return self::useroption( $parser, $user, 'nickname' );
	}

	/**
	 * @param Parser $parser
	 * @param User $user
	 * @param string $option
	 *
	 * @return mixed|void|null
	 */
	public static function useroption( $parser, $user, $option ) {
		global $wgUser, $wgOut, $wgWikiUserInfoSafeOptions;
		if ( !in_array( $option, $wgWikiUserInfoSafeOptions ) && !$wgUser->isAllowed( 'showuseroption' ) &&
			 !$wgUser->isAllowed( 'lookupuser' ) ) {
			$wgOut->showPermissionsErrorPage( [ 'showuseroption' ] );
			return;
		}
		$user = self::getUser( $parser, $user );
		return $user->getOption( $option );
	}

	/**
	 * @param Parser $parser
	 * @param User $user
	 *
	 * @return bool|string|void|null
	 */
	public static function userregistration( $parser, $user ) {
		global $wgUser, $wgOut;
		if ( !$wgUser->isAllowed( 'showuseroption' ) && !$wgUser->isAllowed( 'lookupuser' ) ) {
			$wgOut->showPermissionsErrorPage( [ 'showuseroption' ] );
			return;
		}
		$user = self::getUser( $parser, $user );
		return $user->getRegistration();
	}

	/**
	 * @param Parser $parser
	 * @param User $user
	 *
	 * @return string
	 */
	public static function usergroups( $parser, $user ) {
		$user = self::getUser( $parser, $user );
		return implode( ',', $user->getGroups() );
	}

	/**
	 * @param Parser $parser
	 * @param User $user
	 *
	 * @return int|null
	 */
	public static function useredits( $parser, $user ) {
		$user = self::getUser( $parser, $user );
		return $user->getEditCount();
	}

}
