<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['loginsubmit']= 'Welcome/loginsubmit';
$route['dashboard']= 'Dashboard/index';
$route['logout']= 'Dashboard/logout';
$route['crawlers/(:num)']= 'Crawlers/index';
$route['finding_value/(:any)']= 'Crawlers/findingValue/$1';
$route['finding_value']= 'Crawlers/findingValue';
$route['signup']= 'Welcome/userSignUp';
$route['plan']= 'Plan/index';
$route['addplan']= 'Plan/addPlan';
$route['deleteplan/(:any)']= 'Plan/deleteplan/$1';
$route['addcrawler']= 'Crawlers/addcrawler';
$route['submitcrawler']= 'Crawlers/submitAddcrawler';
$route['add_facebook_groups']= 'Crawlers/secondStep';
$route['submitsndstep']= 'Crawlers/submitSecondStep';
$route['notification_setting']= 'Crawlers/thirdStep';
$route['submittrdstep']= 'Crawlers/submitThirdStep';
$route['editcrawler/(:any)']= 'Crawlers/editcrawler/$1';
$route['editcrawlerinfo/(:any)']= 'Crawlers/editcrawlerInfo/$1';
$route['updtecrawlerinfo/(:any)']= 'Crawlers/updateCrawlerInfo/$1';

$route['delete_crawler/(:any)']= 'Crawlers/deleteCrawler/$1';

//website documentation
$route['start']= 'Dashboard/start';

//upload csv
$route['uploadcsv/(:any)']= 'Crawlers/uploadCSv/$1';
$route['fbgroup_csv']= 'Crawlers/fbGroupCsv';
$route['client_fbgroupcsv']= 'Client/clientFbGroupCsv';

$route['addtag/(:any)']= 'Crawlers/addCrawlerTag/$1';
$route['deletetag/(:any)/(:any)']= 'Crawlers/deleteCrawlerTag/$1/$2';

$route['addgroup/(:any)']= 'Crawlers/addCrawlerGroup/$1';
$route['editgroup/(:any)/(:any)']= 'Crawlers/crawlerEditGroup/$1/$2';
$route['disconnectgroup/(:any)/(:any)']= 'Crawlers/crawlerDisconnectGroup/$1/$2';

$route['updatecrawler/(:any)']= 'Crawlers/updatecrawler/$1';
$route['deletecrawler/(:any)']= 'Crawlers/deletecrawler/$1';


$route['addkeyword/(:any)']= 'Crawlers/addKeyword/$1';
$route['viewkeyword/(:any)']= 'Crawlers/viewKeyword/$1';
$route['uploadkeywordcsv/(:any)']= 'Crawlers/uploadKeywordCSv/$1';

//client keyword csv upload
$route['clientcsv_keyword/(:any)']= 'Client/uploadKeywordCSv/$1';

//ambass client keyword csv upload
$route['ambasscsv_keyword']= 'Ambassadors/uploadKeywordCSv';

//ambass client keyword csv upload
$route['crawlercsv_keyword/(:any)']= 'Crawlers/crawlerCsvKeyword/$1';

$route['deleteAdminKeyword/(:any)/(:any)']= 'Crawlers/adminDeleteKeyword/$1/$2';
$route['editAdminKeyword/(:any)/(:any)']= 'Crawlers/adminEditKeyword/$1/$2';
$route['addadminkeyword/(:any)']= 'Crawlers/addClientKeyword/$1';

$route['deleteKeyword/(:any)/(:any)']= 'Crawlers/crawlerDeleteKeyword/$1/$2';
$route['editKeyword/(:any)/(:any)']= 'Crawlers/crawlerEditKeyword/$1/$2';
$route['updateCrwalerkeyword/(:any)/(:any)']= 'Crawlers/updateCrwalerkeyword/$1/$2';

//form_keyword

$route['client']= 'Client/index';
$route['crawler_name']= 'Client/crawlerName';

$route['addclient']= 'Client/addclient';
$route['editclient/(:any)']= 'Client/editclient/$1';
// $route['updateclient/(:any)']= 'Client/updateclient/$1';
$route['deleteclient/(:any)']= 'Client/deleteclient/$1';
//$route['select_country/(:any)/(:any)']='RegisterController/selectCountry/$1/$2';


/*=====================================================================
                        Ambassadors Section Start
=======================================================================*/
$route['ambassadors']= 'Ambassadors/index';
$route['ambassadors_add']= 'Ambassadors/ambassadorsAdd';
$route['ambassadors_edit/(:any)']= 'Ambassadors/ambassadorsEdit/$1';



$route['ambassadors_report']= 'Ambassadors/ambassadorsReport';
$route['ambassadors_dropdown']= 'Ambassadors/ambassadorsDropdown';
$route['deactiveuser/(:any)']= 'Ambassadors/deactiveUser/$1';
$route['activeuser/(:any)']= 'Ambassadors/activeUser/$1';
/*=====================================================================
                        Ambassadors Section End
=======================================================================*/
$route['report']= 'Report/index';
$route['getreport/(:num)']= 'Report/getFilterDataFromOther';
$route['getreport']= 'Report/getFilterDataFromOther';

$route['load_report/(:num)']= 'Report/LoadReportData';
$route['load_report']= 'Report/LoadReportData';

$route['trigger']= 'Triggers/index';
$route['notification']= 'Notification/index';
$route['getNotification']= 'Notification/getNotification';
$route['clientreport']= 'Clientreport/index';

/*=====================================================================
                        Ambassadors Panel Start
=======================================================================*/

$route['recommendation']= 'Recommendation/index';

$route['getrecommendation/(:any)']= 'Recommendation/getFilterData';
$route['getrecommendation']= 'Recommendation/getFilterData';

$route['update_ambass_tag']= 'Recommendation/updateTag';

$route['set_current_user']= 'Ambassadorspanel/set_current_user';
$route['add_notification_settings/(:any)']= 'Ambassadorspanel/addNotificationSettings/$1';
// $route['ambassadors_account/(:any)']= 'Crawlers/ambassadorsAccount/$1';
$route['ambassadors_account/(:any)']= 'Ambassadors/ambassadorsAccount/$1';
$route['ambassadors_notification/(:any)']= 'Crawlers/ambassadorsNotification/$1';
$route['deletenoti/(:any)']= 'Ambassadorspanel/deletenoti/$1';
$route['change_password/(:any)']= 'Crawlers/changePassword/$1';
$route['change_status/(:any)']= 'Crawlers/changeStatus/$1';

// $route['ambassadors_report']= 'Ambassadors/ambassadorsReport';
// $route['ambassadors_dropdown']= 'Ambassadors/ambassadorsDropdown';

/*=====================================================================
                        Ambassadors Panel End
=======================================================================*/

/*=====================================================================
                        Client Report Section Start
=======================================================================*/
$route['clientreport']= 'Clientreport/index';
$route['create_report']= 'Clientreport/createReport';

$route['client_pdf']= 'Clientreport/clientPdf';
$route['generate_pdf']= 'Clientreport/generatePdf';

$route['getclinetinfo']= 'Clientreport/getclinetInfo';

$route['view_clientpdf/(:any)']= 'Clientreport/viewClientPdf/$1';
$route['delete_clientreport/(:any)']= 'Clientreport/deleteClientReport/$1';

/*=====================================================================
                        Client Report Section End
=======================================================================*/

/*=====================================================================
                        Client Panel Start
=======================================================================*/
$route['tags']= 'Client/myTag';
$route['addclienttags']= 'Client/addclienttags';
$route['deleteclienttags/(:any)']= 'Client/deleteCrawlerTag/$1';

$route['client_recommendation']= 'Client/clientRemmendation';

$route['getclientrecommendation/(:any)']= 'Client/getClientFilterData';
$route['getclientrecommendation']= 'Client/getClientFilterData';

$route['update_client_tag']= 'Client/updateClientTag';

$route['clientgroups']= 'Client/clientgroups';
// $route['insert_client_groups']= 'Client/insertClientGroups';

$route['client_profile']= 'Client/clientProfile';

$route['client_onboarding']= 'Client/clientOnboarding';
$route['client_onboardingsubmit']= 'Client/clientOnboardingSubmit';

/*=====================================================================
                        Crawler Panel Start
=======================================================================*/
$route['crawler_recommendation']= 'Crawlers/crawlerRecommendation';


$route['getcrawlerrecommendation']= 'Crawlers/getCrawlerFilterData';
$route['getcrawlerrecommendation/(:num)']= 'Crawlers/getCrawlerFilterData';
$route['crawler_groups']= 'Crawlers/crawlerGroups';
$route['crawler_groups_delete/(:any)']= 'Crawlers/crawlerGroupsDelete/$1';
$route['crawler_keyword']= 'Crawlers/crawlerKeyword';
$route['crawler_update_keyword/(:any)']= 'Crawlers/crawlerUpdateKeyword/$1';
$route['crawler_account']= 'Crawlers/crawlerAccount';
$route['update_crawler_tag']= 'Crawlers/updateCrawlerTag';
$route['crawlercsv_group/(:any)']= 'Crawlers/crawlerCsvGroup/$1';

$route['show_crawler_name']= 'Crawlers/showCrawlerName';

/*=====================================================================
                        Manage Tag Section Start
=======================================================================*/
$route['managetag']= 'Managetag/index';
$route['taglist_add']= 'Managetag/taglistAdd';
$route['taglist_delete/(:any)']= 'Managetag/taglistDelete/$1';
/*=====================================================================
                        Manage Tag Section End
=======================================================================*/

/*=====================================================================
                        Password Section
=======================================================================*/
$route['forgot_pass']= 'Welcome/forgotPass';
$route['reset_pass/(:any)']= 'Welcome/resetPass/$1';
/*=====================================================================
                        Password Section End
=======================================================================*/

/*=====================================================================
                        Account Panel Start
=======================================================================*/
$route['clientaccount']= 'Client/clientAccount';
$route['client_password/(:any)']= 'Client/changePassword/$1';
$route['clientaddgroup']= 'Client/addClientGroup';
$route['clientdisconnectgroup/(:any)']= 'Client/ClientDisconnectGroup/$1';
$route['client_notification']= 'Client/clientNotification';

$route['clientkeyword']= 'Client/clientKeywords';
$route['addClientkeyword']= 'Client/addClientKeywords';
$route['removekeyword/(:any)']= 'Client/clientRemoveKeywords/$1';
$route['editclientkeyword/(:any)']= 'Client/editClientkeyword/$1';
$route['updateclientkeyword/(:any)']= 'Client/updateClientkeyword/$1';

$route['client_image/(:any)']= 'Client/clientImage/$1';

/*=====================================================================
                        Account Panel End
=======================================================================*/



/*=====================================================================
                        Ambassador Groups And Keyword Panel Start
=======================================================================*/

$route['ambass_groups_view']= 'Crawlers/ambassadorViewClientGroups';
$route['ambass_key_view']= 'Crawlers/ambassadorViewClientKeyword';

$route['ambass_add_groups'] = 'Crawlers/ambassadorsAddGroup';
$route['ambass_add_key'] = 'Crawlers/ambassadorAddKeyword';

$route['ambass_edit_key/(:any)'] = 'Crawlers/ambassadorEditKeyword/$1';
$route['ambass_update_key/(:any)'] = 'Crawlers/ambassadorUpdateKeyword/$1';

$route['ambass_disconnect_group/(:any)']= 'Crawlers/ambassDisconnectGroup/$1';
$route['ambass_delete_key/(:any)'] = 'Crawlers/ambassDeleteKey/$1';

/*=====================================================================
                        Ambassador Groups And Keyword Panel End
=======================================================================*/




/*=====================================================================
                       Team member depends
=======================================================================*/

$route['teammember_depand/(:any)'] = 'Client/teammemberDepand/$1';
$route['onboarding_team_depand/(:any)'] = 'Client/onboardingTeamDepand/$1';

$route['admin_category_filter'] = 'Client/adminCategoryFilter';

// $route['onboarding_team_depand/(:any)'] = 'Clientonboarding/onboardingTeamDepand/$1';

/*=====================================================================
                       Keywords Update
=======================================================================*/

$route['update_mustinc_value'] = 'Crawlers/updateMustincValue';
$route['remove_mustinc_value'] = 'Crawlers/removeMustincValue';

$route['update_recomreply_value'] = 'Crawlers/updateRecomreplyValue';
$route['remove_recomreply_value'] = 'Crawlers/removeRecomreplyValue';

$route['crawler_change'] = 'Client/crawlerChange';

/*=====================================================================
                       Facebook Group Category
=======================================================================*/

$route['fb_group_category'] = 'Client/fbGroupCategory';
// $route['fb_group_category'] = 'Clientonboarding/fbGroupCategory';
$route['fetch_client_onboarding_groups'] = 'Client/fetchClientOnboardingGroups';
// $route['fetch_client_onboarding_groups'] = 'Clientonboarding/fetchClientOnboardingGroups';

$route['onboarding_registration'] = 'Client/onboardingRegistration';
// $route['onboarding_registration'] = 'Clientonboarding/onboardingRegistration';

$route['select_all_facebook_groups'] = 'Crawlers/selectAllFacebookGroups';
$route['unselect_all_facebook_groups'] = 'Crawlers/unselectAllFacebookGroups';
$route['search_facebook_groups'] = 'Crawlers/searchFacebookGroups';

/*=====================================================================
                       Ambassadors Profile Update
=======================================================================*/
$route['update_profile_info'] = 'Ambassadors/updateProfileInfo';
$route['ambassador_profile'] = 'Ambassadors/ambassadorProfile';

/*=====================================================================
                       email_validite_check
=======================================================================*/
$route['email_validite_check'] = 'Dashboard/emailValiditeCheck';

/*=====================================================================
                       Crawler Profile Update
=======================================================================*/
$route['crawler_profile'] = 'Crawlers/crawlerProfile';

/*=====================================================================
                       Admin Report
=======================================================================*/
$route['selected_account_associated_tag'] = 'Report/selectedAccountAssociatedTag';
$route['export_to_csv'] = 'Report/exportToCsv';
$route['export_to_csv_custom'] = 'Report/exportToCsvCustom';




