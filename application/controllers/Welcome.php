<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model("merge_model");
		$this->load->library("DateTimeService");
	}
	public function index()
	{
		$this->load->view("welcome_message");
	}
	public function transfer(){

		$this->merge_model->setMaxId();
		$account_tbl = array('accounts','franchise_accounts','franchises','custom_lead_field','sales_areas','position_permissions','pay_periods','payment_accounts','page_permissions','lead_image_types','lead_generation_type','leads','leads_milestones','lead_form_apis','lead_images','lead_sources','lead_document_types','milestones','document_templates','account_permissions','account_utility_companies','account_vendors','accounts_pricing_packages','account_user_licenses','account_contract_details','account_generated_leads','appointment_blocks','api_keys','actions','activity_types','configs','custom_positions','email_configs','installers','timecards','timecard_edit_requests','commission_payouts','commission_rules','documents','locations','managers','proposal_writers','push_notifications','quick_leads','sales','schedulers','site_alerts','users','custom_lead_fields','appointments','events');
		$franchise_tbl = array('franchises','franchise_accounts','accounts','custom_lead_field','sales_areas','position_permissions','pay_periods','payment_accounts','page_permissions','lead_image_types','lead_generation_type','leads','leads_milestones','lead_form_apis','lead_images','lead_sources','lead_document_types','milestones','document_templates','account_permissions','account_utility_companies','account_vendors','accounts_pricing_packages','account_user_licenses','account_contract_details','account_generated_leads','appointment_blocks','api_keys','actions','activity_types','configs','custom_positions','email_configs','installers','timecards','timecard_edit_requests','commission_payouts','commission_rules','documents','locations','managers','proposal_writers','push_notifications','quick_leads','sales','schedulers','site_alerts','users','custom_lead_fields','appointments','events');
		$account_id = $this->input->get_post('account_id');
		$franchise_id = $this->input->get_post('franchise_id');
		$arr = array();
		if ($account_id !="")
			$arr = $account_id;
		else
			$arr = $franchise_id;

		for ($i = 0; $i < count($arr); $i++){
			if ($account_id != ""){
				foreach ($account_tbl as $key => $val) {
					# code...

					$this->merge_model->transferTbl($val,$arr[$i]);
				}
				// $this->merge_model->transferTbl("franchise_accounts",$arr[$i]);
				// $this->merge_model->transferTbl("franchises",$arr[$i]);
			}
			else if ($account_id == "" && $franchise_id != ""){
				foreach ($franchise_tbl as $key => $val) {
					# code...

					$this->merge_model->transferTbl($val,null,$arr[$i]);
				}
				// $this->merge_model->transferTbl("franchises",null,$arr[$i]);
				// $this->merge_model->transferTbl("franchise_accounts",null,$arr[$i]);
				// $this->merge_model->transferTbl("accounts",null,$arr[$i]);

				$this->merge_model->updateSST($arr[$i]);
			}
		}
        $list = $this->merge_model->getTblname();

		// $this->merge_model->transferTbl("leads");
        foreach ($list as $key => $value) {
        	$val = $value["Tables_in_solar_sales_tracker"];
        	if (!in_array($val, $account_tbl) && !in_array($val, $franchise_tbl))
        	{

				$this->merge_model->transferTbl($val);
        	}
        }

        foreach ($list as $key => $value) {
        	$val = $value["Tables_in_solar_sales_tracker"];
        	if ($val != "accounts" && $val != "franchises" && $val != "franchise_accounts" )
        	{

				$this->merge_model->updateTbl($val);
			}
        }

        // foreach ($list as $key => $value) {
        // 	$val = $value["Tables_in_solar_sales_tracker"];
	       //  $this->merge_model->write("Delete Start"."\n\r");
        //  	$this->merge_model->delField($val);
        // }
		//$this->session->unset_userdata("max_account_id");

	}
	public function getAccount(){
		$result = $this->merge_model->getAccount();
		echo json_encode($result);
	}
	public function getFranchise(){
		$result = $this->merge_model->getFranchise();
		echo json_encode($result);
	}
}
