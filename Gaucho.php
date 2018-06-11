<?php

class SkinGaucho extends SkinTemplate {

	public $skinname = 'gaucho';

	public $template = 'GauchoTemplate';

	static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		if ( $skin->getUser()->getOption( 'skin' ) === 'gaucho' ) {
			$out->enableOOUI();
			$out->addModuleStyles([
				'skins.gaucho.styles',
				'oojs-ui-core.styles'
			]);
			$out->addModules( 'skins.gaucho' );
			$out->addMeta( 'viewport', 'width=device-width' );
		}
	}
}

class GauchoTemplate extends BaseTemplate {

	/**
	 * Echo the logo src
	 */
	function logoSrc() {
		global $wgLogo;
		echo $wgLogo;
	}

	/**
	 * Echo the site name
	 */
	function siteName() {
		global $wgSitename;
		echo $wgSitename;
	}

	/**
	 * Echo the main page URL
	 */
	function mainPageUrl() {
		echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] );
	}

	/**
	 * Echo the search bar
	 */
	function searchInput() {
		echo new MediaWiki\Widget\SearchInputWidget([
			'name' => 'search'
		]);
	}

	/**
	 * Echo the User button
	 */
	function userButton() {
		echo new OOUI\ButtonWidget([
			'id' => 'user-button',
			'label' => wfMessage( 'gaucho-my-account' )->text()
		]);
	}

	/**
	 * Customize the user menu
	 */
	function getUserMenu() {
		$userMenu = $this->getPersonalTools();
		unset( $userMenu['notifications-alert'] );
		unset( $userMenu['notifications-notice'] );
		return $userMenu;
	}

	/**
	 * Merge together the views, actions and variants
	 * and remove the current action, per useless and confusing
	 */
	function getActions() {
		global $mediaWiki;
		$actions = array_merge(
			$this->data['content_navigation']['views'],
			$this->data['content_navigation']['actions'],
			$this->data['content_navigation']['variants']
		);
		$action = $mediaWiki->getAction();
		if ( $action === 'view' ) {
			unset( $actions['view'] ); // Remove the View action when viewing
		}
		return $actions;
	}

	/**
	 * Get the notifications of the Echo extension
	 */
	function getNotifications() {
		$notifications = [];
		$personalTools = $this->getPersonalTools();
		if ( array_key_exists( 'notifications-alert', $personalTools ) ) {
			$notifications['notifications-alert'] = $personalTools['notifications-alert'];
			$notifications['notifications-notice'] = $personalTools['notifications-notice'];
		}
		return $notifications;
	}

	/**
	 * Output the page
	 */
	function execute() {
		include 'Gaucho.phtml';
	}
}