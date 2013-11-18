<?php
/**
*
**/
class PrestashopModuleGenerator
{
	//protected $template;
	
	/*
	* @var Twig_Environement instance
	*/
	private $twig;

	protected static $hooks  = array(
		array('name' => 'displayPayment','title' => 'Payment','description' => ''),
		array('name' => 'actionValidateOrder','title' => 'New orders','description' => ''),
		array('name' => 'actionPaymentConfirmation','title' => 'Payment confirmation','description' => ''),
		array('name' => 'displayPaymentReturn','title' => 'Payment return','description' => ''),
		array('name' => 'actionUpdateQuantity','title' => 'Quantity update','description' => 'Quantity is updated only when the customer effectively place his order.'),
		array('name' => 'displayRightColumn','title' => 'Right column blocks','description' => ''),
		array('name' => 'displayLeftColumn','title' => 'Left column blocks','description' => ''),
		array('name' => 'displayHome','title' => 'Homepage content','description' => ''),
		array('name' => 'displayHeader','title' => 'Header of pages','description' => 'A hook which allow you to do things in the header of each pages'),
		array('name' => 'actionCartSave','title' => 'Cart creation and update','description' => ''),
		array('name' => 'actionAuthentication','title' => 'Successful customer authentication','description' => ''),
		array('name' => 'actionProductAdd','title' => 'Product creation','description' => ''),
		array('name' => 'actionProductUpdate','title' => 'Product Update','description' => ''),
		array('name' => 'displayTop','title' => 'Top of pages','description' => 'A hook which allow you to do things a the top of each pages.'),
		array('name' => 'displayRightColumnProduct','title' => 'Extra actions on the product page (right column).','description' => ''),
		array('name' => 'actionProductDelete','title' => 'Product deletion','description' => 'This hook is called when a product is deleted'),
		array('name' => 'displayFooterProduct','title' => 'Product footer','description' => 'Add new blocks under the product description'),
		array('name' => 'displayInvoice','title' => 'Invoice','description' => 'Add blocks to invoice (order)'),
		array('name' => 'actionOrderStatusUpdate','title' => 'Order\'s status update event','description' => 'Launch modules when the order\'s status of an order change.'),
		array('name' => 'displayAdminOrder','title' => 'Display in Back-Office, tab AdminOrder','description' => 'Launch modules when the tab AdminOrder is displayed on back-office.'),
		array('name' => 'displayFooter','title' => 'Footer','description' => 'Add block in footer'),
		array('name' => 'displayPDFInvoice','title' => 'PDF Invoice','description' => 'Allow the display of extra informations into the PDF invoice'),
		array('name' => 'displayAdminCustomers','title' => 'Display in Back-Office, tab AdminCustomers','description' => 'Launch modules when the tab AdminCustomers is displayed on back-office.'),
		array('name' => 'displayOrderConfirmation','title' => 'Order confirmation page','description' => 'Called on order confirmation page'),
		array('name' => 'actionCustomerAccountAdd','title' => 'Successful customer create account','description' => 'Called when new customer create account successfuled'),
		array('name' => 'displayCustomerAccount','title' => 'Customer account page display in front office','description' => 'Display on page account of the customer'),
		array('name' => 'actionOrderSlipAdd','title' => 'Called when a order slip is created','description' => 'Called when a quantity of one product change in an order.'),
		array('name' => 'displayProductTab','title' => 'Tabs on product page','description' => 'Called on order product page tabs'),
		array('name' => 'displayProductTabContent','title' => 'Content of tabs on product page','description' => 'Called on order product page tabs'),
		array('name' => 'displayShoppingCartFooter','title' => 'Shopping cart footer','description' => 'Display some specific informations on the shopping cart page'),
		array('name' => 'displayCustomerAccountForm','title' => 'Customer account creation form','description' => 'Display some information on the form to create a customer account'),
		array('name' => 'displayAdminStatsModules','title' => 'Stats - Modules','description' => ''),
		array('name' => 'displayAdminStatsGraphEngine','title' => 'Graph Engines','description' => ''),
		array('name' => 'actionOrderReturn','title' => 'Product returned','description' => ''),
		array('name' => 'displayProductButtons','title' => 'Product actions','description' => 'Put new action buttons on product page'),
		array('name' => 'displayBackOfficeHome','title' => 'Administration panel homepage','description' => ''),
		array('name' => 'displayAdminStatsGridEngine','title' => 'Grid Engines','description' => ''),
		array('name' => 'actionWatermark','title' => 'Watermark','description' => ''),
		array('name' => 'actionProductCancel','title' => 'Product cancelled','description' => 'This hook is called when you cancel a product in an order'),
		array('name' => 'displayLeftColumnProduct','title' => 'Extra actions on the product page (left column).','description' => ''),
		array('name' => 'actionProductOutOfStock','title' => 'Product out of stock','description' => 'Make action while product is out of stock'),
		array('name' => 'actionProductAttributeUpdate','title' => 'Product attribute update','description' => ''),
		array('name' => 'displayCarrierList','title' => 'Extra carrier (module mode)','description' => ''),
		array('name' => 'displayShoppingCart','title' => 'Shopping cart extra button','description' => 'Display some specific informations'),
		array('name' => 'actionSearch','title' => 'Search','description' => ''),
		array('name' => 'displayBeforePayment','title' => 'Redirect in order process','description' => 'Redirect user to the module instead of displaying payment modules'),
		array('name' => 'actionCarrierUpdate','title' => 'Carrier Update','description' => 'This hook is called when a carrier is updated'),
		array('name' => 'actionOrderStatusPostUpdate','title' => 'Post update of order status','description' => ''),
		array('name' => 'displayCustomerAccountFormTop','title' => 'Block above the form for create an account','description' => ''),
		array('name' => 'displayBackOfficeHeader','title' => 'Administration panel header','description' => ''),
		array('name' => 'displayBackOfficeTop','title' => 'Administration panel hover the tabs','description' => ''),
		array('name' => 'displayBackOfficeFooter','title' => 'Administration panel footer','description' => ''),
		array('name' => 'actionProductAttributeDelete','title' => 'Product Attribute Deletion','description' => ''),
		array('name' => 'actionCarrierProcess','title' => 'Carrier Process','description' => ''),
		array('name' => 'actionOrderDetail','title' => 'Order Detail','description' => 'To set the follow-up in smarty when order detail is called'),
		array('name' => 'displayBeforeCarrier','title' => 'Before carrier list','description' => 'This hook is display before the carrier list on Front office'),
		array('name' => 'displayOrderDetail','title' => 'Order detail displayed','description' => 'Displayed on order detail on front office'),
		array('name' => 'actionPaymentCCAdd','title' => 'Payment CC added','description' => 'Payment CC added'),
		array('name' => 'displayProductComparison','title' => 'Extra Product Comparison','description' => 'Extra Product Comparison'),
		array('name' => 'actionCategoryAdd','title' => 'Category creation','description' => ''),
		array('name' => 'actionCategoryUpdate','title' => 'Category modification','description' => ''),
		array('name' => 'actionCategoryDelete','title' => 'Category removal','description' => ''),
		array('name' => 'actionBeforeAuthentication','title' => 'Before Authentication','description' => 'Before authentication'),
		array('name' => 'displayPaymentTop','title' => 'Top of payment page','description' => 'Top of payment page'),
		array('name' => 'actionHtaccessCreate','title' => 'After htaccess creation','description' => 'After htaccess creation'),
		array('name' => 'actionAdminMetaSave','title' => 'After save configuration in AdminMeta','description' => 'After save configuration in AdminMeta'),
		array('name' => 'displayAttributeGroupForm','title' => 'Add fields to the form "attribute group"','description' => 'Add fields to the form "attribute group"'),
		array('name' => 'actionAttributeGroupSave','title' => 'On saving attribute group','description' => 'On saving attribute group'),
		array('name' => 'actionAttributeGroupDelete','title' => 'On deleting attribute group','description' => 'On deleting attribute group'),
		array('name' => 'displayFeatureForm','title' => 'Add fields to the form "feature"','description' => 'Add fields to the form "feature"'),
		array('name' => 'actionFeatureSave','title' => 'On saving attribute feature','description' => 'On saving attribute feature'),
		array('name' => 'actionFeatureDelete','title' => 'On deleting attribute feature','description' => 'On deleting attribute feature'),
		array('name' => 'actionProductSave','title' => 'On saving products','description' => 'On saving products'),
		array('name' => 'actionProductListOverride','title' => 'Assign product list to a category','description' => 'Assign product list to a category'),
		array('name' => 'displayAttributeGroupPostProcess','title' => 'On post-process in admin attribute group','description' => 'On post-process in admin attribute group'),
		array('name' => 'displayFeaturePostProcess','title' => 'On post-process in admin feature','description' => 'On post-process in admin feature'),
		array('name' => 'displayFeatureValueForm','title' => 'Add fields to the form "feature value"','description' => 'Add fields to the form "feature value"'),
		array('name' => 'displayFeatureValuePostProcess','title' => 'On post-process in admin feature value','description' => 'On post-process in admin feature value'),
		array('name' => 'actionFeatureValueDelete','title' => 'On deleting attribute feature value','description' => 'On deleting attribute feature value'),
		array('name' => 'actionFeatureValueSave','title' => 'On saving attribute feature value','description' => 'On saving attribute feature value'),
		array('name' => 'displayAttributeForm','title' => 'Add fields to the form "attribute value"','description' => 'Add fields to the form "attribute value"'),
		array('name' => 'actionAttributePostProcess','title' => 'On post-process in admin feature value','description' => 'On post-process in admin feature value'),
		array('name' => 'actionAttributeDelete','title' => 'On deleting attribute feature value','description' => 'On deleting attribute feature value'),
		array('name' => 'actionAttributeSave','title' => 'On saving attribute feature value','description' => 'On saving attribute feature value'),
		array('name' => 'actionTaxManager','title' => 'Tax Manager Factory','description' => ''),
		array('name' => 'displayMyAccountBlock','title' => 'My account block','description' => 'Display extra informations inside the "my account" block'),
		array('name' => 'actionAdminMetaControllerUpdate_optionsBefore','title' => 'actionAdminMetaControllerUpdate_optionsBefore','description' => ''),
		array('name' => 'actionAdminLanguagesControllerStatusBefore','title' => 'actionAdminLanguagesControllerStatusBefore','description' => ''),
		array('name' => 'actionShopDataDuplication','title' => 'actionShopDataDuplication','description' => ''),
		array('name' => 'actionBeforeSubmitAccount','title' => 'actionBeforeSubmitAccount','description' => ''),
		array('name' => 'displayMyAccountBlockfooter','title' => 'My account block','description' => 'Display extra informations inside the "my account" block'),
		array('name' => 'displayMobileTopSiteMap','title' => 'displayMobileTopSiteMap','description' => ''),
		array('name' => 'actionObjectCategoryUpdateAfter','title' => 'actionObjectCategoryUpdateAfter','description' => ''),
		array('name' => 'actionObjectCategoryDeleteAfter','title' => 'actionObjectCategoryDeleteAfter','description' => ''),
		array('name' => 'actionObjectCmsUpdateAfter','title' => 'actionObjectCmsUpdateAfter','description' => ''),
		array('name' => 'actionObjectCmsDeleteAfter','title' => 'actionObjectCmsDeleteAfter','description' => ''),
		array('name' => 'actionObjectSupplierUpdateAfter','title' => 'actionObjectSupplierUpdateAfter','description' => ''),
		array('name' => 'actionObjectSupplierDeleteAfter','title' => 'actionObjectSupplierDeleteAfter','description' => ''),
		array('name' => 'actionObjectManufacturerUpdateAfter','title' => 'actionObjectManufacturerUpdateAfter','description' => ''),
		array('name' => 'actionObjectManufacturerDeleteAfter','title' => 'actionObjectManufacturerDeleteAfter','description' => ''),
		array('name' => 'actionObjectProductUpdateAfter','title' => 'actionObjectProductUpdateAfter','description' => ''),
		array('name' => 'actionObjectProductDeleteAfter','title' => 'actionObjectProductDeleteAfter','description' => '')
	);

	protected static $tabs = array('administration', 'advertising_marketing', 'analytics_stats', 'billing_invoicing', 'checkout',
		'front_office_features', 'migration_tools', 'payments_gateways', 'payment_security', 'pricing_promotion', 'search_filter',
		'seo', 'shipping_logistics', 'smart_shopping', 'market_place', 'mobile', 'custom');

	public function __construct($app)
	{
		$filter = new Twig_SimpleFilter('ucfirst', 'ucfirst');
		$this->twig = $app['twig'];
		$this->twig->addFilter($filter);
	}

	/**
	*
	* @return mixed bool|string False if failled, url to generated file if success
	*/
	public function generate($data)
	{
		// $this->twig->loadTemplate('module.php.twig');
		// $output = $this->twig->render('module.php.twig', $data);
		return $this->twig->render('module.php.twig', $data);
	}

	/**
	* Hooks list array formated as [<name> => <name>, ...]
	* @return array [<name> => <name>, ...]
	*/
	public static function getHooksListData()
	{
		return  array_combine(array_column(self::$hooks, 'name'), array_column(self::$hooks, 'name'));
	}

	/**
	* Module tabs list
	* @return array [<tab_id>, ... ]
	*/
	public static function getTabs()
	{
		return array_combine (self::$tabs, self::$tabs);
	}
}