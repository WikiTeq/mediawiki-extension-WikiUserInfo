<?php

namespace WikiUserInfo;

use Parser;

class WikiUserInfoHooks {

	/**
	 * @param Parser $parser
	 */
	public static function onParserFirstCallInit( $parser ) {
		$parser->setFunctionHook( 'realname', [ WikiUserInfo::class, "realname" ] );
		$parser->setFunctionHook( 'email', [ WikiUserInfo::class, "email" ] );
		$parser->setFunctionHook( 'nickname', [ WikiUserInfo::class, "nickname" ] );
		$parser->setFunctionHook( 'useroption', [ WikiUserInfo::class, "useroption" ] );
		$parser->setFunctionHook( 'userregistration', [ WikiUserInfo::class, "userregistration" ] );
		$parser->setFunctionHook( 'usergroups', [ WikiUserInfo::class, "usergroups" ] );
		$parser->setFunctionHook( 'useredits', [ WikiUserInfo::class, "useredits" ] );
	}

}
