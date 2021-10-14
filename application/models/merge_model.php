<?php 

class Merge_model extends CI_Model
{
    var $rules = array( 
        'normal_import'=>array('franchises','api_tokens','alert_types','dashboard_widgets','custom_lead_field_value','disposition_types','accounts','time_off_requests'),
        'account_plus'=>array('sales_areas','position_permissions','pay_periods','payment_accounts','page_permissions','milestones','lead_image_types','lead_generation_type','lead_document_types','document_templates','account_permissions','account_utility_companies','account_vendors','accounts_pricing_packages','account_user_licenses','account_contract_details','account_generated_leads','appointment_blocks','api_keys','actions','activity_type','configs','custom_positions','email_configs','installers','timecards','timecard_edit_requests'),
        'activities'=>array('associated_id'=>0,'lead_id'=>0,'user_id'=>0),        
        'alert_recipients'=>array('site_alert_id'=>0),
        'appointments'=>array('customer_id'=>0,'lead_id'=>0,'closer_id'=>0,'scheduler_id'=>0,'user_id'=>0, 'account_id'=>0),
        'calendar_colors'=>array('user_id'=>0),
        'closers'=>array('user_id'=>0,'account_id'=>0),
        'closers_schedulers'=>array('scheduler_id'=>0,'closer_id'=>0),
        'commission_payouts'=>array('user_id'=>0,'lead_id'=>0,'account_id'=>0),
        'commission_rules'=>array('lead_source_id'=>0,'account_id'=>0),
        'customers'=>array('lead_id'=>0,'user_id'=>0,'cell_phone'=>'primary_phone','home_phone'=>'secondary_phone'),
        'customer_portal_documents'=>array('customer_id'=>0),
        'custom_lead_fields'=>array('franchise_id'=>0,'account_id'=>0),
        'dashboard_layouts'=>array('updated_id'=>0,'user_id'=>0),
        'dashboard_pages'=>array('updated_id'=>0,'user_id'=>0),
        'dashboard_page_layouts'=>array('updated_id'=>0,'user_id'=>0),
        'dashboard_widgets'=>array('user_id'=>0),
        'documents'=>array('customer_id'=>0,'lead_id'=>0,'document_template_id'=>0,"lead_document_id"=>0,"account_id"=>0),
        'edited_documents'=>array('customer_id'=>0,'lead_id'=>0,'document_template_id'=>0,'user_id'=>0),
        'energy_usages'=>array('lead_id'=>0),
        'events'=>array('user_id'=>0, 'account_id'=>0),
        'franchise_accounts'=>array('account_id'=>0,'franchise_id'=>0),
        'franchise_user_permissions'=>array('user_id'=>0),
        'leads'=>array('installer_id'=>0,'user_id'=>0,'location_id'=>0,'account_id'=>0,'closer_id'=>0,'scheduler_id'=>0,'disposition_type_id'=>0,'milestone_id'=>0,'associated_id'=>0, 'sales_owner'=>0),
        'leads_milestones'=>array('lead_id'=>0,'user_id'=>0,'account_id'=>0,'milestone_id'=>0,'path_item_id'=>0),
        'leads_milestones_conditions'=>array('leads_milestone_id'=>0,'user_id'=>0),
        'lead_add_on_forms'=>array('lead_id'=>0),
        'lead_dispositions'=>array('lead_id'=>0,'appointment_id'=>0),
        'lead_documents'=>array('lead_id'=>0,'lead_document_type_id'=>0),
        'lead_form_apis'=>array('account_id'=>0,'lead_source_id'=>0),
        'lead_images'=>array('account_id'=>0,'lead_id'=>0,'lead_image_type_id'=>0),
        'lead_kwhs'=>array('lead_id'=>0),
        'lead_notes'=>array('lead_id'=>0,'user_id'=>0),
        'lead_sources'=>array('account_id'=>0,'lead_generation_type_id'=>0,'franchise_id'=>0),
        'lead_notes'=>array('lead_id'=>0,'user_id'=>0),
        'locations'=>array('account_id'=>0,'user_id'=>0),
        'managers'=>array('user_id'=>0,'account_id'=>0),
        'managers_users'=>array('user_id'=>0,'manager_id'=>0),
        'metrics_finals'=>array('lead_id'=>0),
        'metrics_installs'=>array('lead_id'=>0),
        'metrics_proposals'=>array('lead_id'=>0),
        'milestone_conditions'=>array('milestone_id'=>0),
        'milestone_alerts'=>array('milestone_id'=>0),
        'milestones_conditions_alerts'=>array('milestone_conditions_id'=>0),
        'module_arrays'=>array('lead_id'=>0),
        'monthly_usages'=>array('lead_id'=>0),
        'payment_plans'=>array('user_id'=>0),
        'proposals'=>array('lead_id'=>0),
        'proposal_writers'=>array('user_id'=>0,'account_id'=>0),
        'proposal_writers_closers'=>array('closer_id'=>0,'proposal_writer_id'=>0),
        'push_notifications'=>array('user_id'=>0,'account_id'=>0),
        'quick_leads'=>array('lead_source_id'=>0,'account_id'=>0,'user_id'=>0,'location_id'=>0),
        'report_layouts'=>array('user_id'=>0),
        'sales'=>array('lead_id'=>0,'closer_id'=>0,'account_id'=>0),
        'schedulers'=>array('user_id'=>0,'account_id'=>0),
        'schedulers_closers'=>array('scheduler_id'=>0,'closer_id'=>0),
        'search_filters'=>array('closer_id'=>0),
        'signatures'=>array('customer_id'=>0,'user_id'=>0,'lead_id'=>0,'document_id'=>0),
        'site_alerts'=>array('user_id'=>0,'account_id'=>0),
        'users'=>array('account_id'=>0,'franchise_id'=>0),
        'users_groups'=>array('user_id'=>0),
        'users_positions'=>array('user_id'=>0),
        'users_sales_areas'=>array('user_id'=>0),
        'user_accountabilities'=>array('location_id '=>0),
        'user_availabilities'=>array('user_id'=>0),
        'user_configs'=>array('user_id'=>0),
        'user_permissions'=>array('user_id'=>0),
        'user_tool_states'=>array('user_id'=>0)
    );
    function __construct()
    {
        parent::__construct();
    }

    function setMaxId(){
        $list = $this->getTblname();
        $max_tbl_id = array();
        foreach ($list as $key => $value) {
            $val = $value["Tables_in_solar_sales_tracker"];
            $tempval = $val;
            if($val == "email_configs")
                $tempval = "email_settings";
            //$table_sql = "SHOW TABLES FROM smartboard_prod LIKE '".$val."'";
            $table_sql = "SHOW TABLES FROM smartboard_prod LIKE '".$tempval."'";
            $r = $this->db->query($table_sql);

            if ($r->num_rows() > 0){
                if ($val == "activities"){
                    $max_tbl_id["associateds"] = $this->getMaxId($val,"associated_id");
                    $this->session->set_userdata('max_associateds_id', $max_tbl_id["associateds"]);
                }
                else if ($val == "lead_generation_type"){
                    $max_tbl_id[$val] = $this->getMaxId($val,"id");
                    $this->session->set_userdata('max_lead_generation_types_id', $max_tbl_id[$val]);
                }
                else if ($val == "milestone_conditions"){
                    $max_tbl_id[$val] = $this->getMaxId($val,"id");
                    $this->session->set_userdata('max_milestone_conditionss_id', $max_tbl_id[$val]);
                }
                else{
                    //$max_tbl_id[$val] = $this->getMaxId($val,"id");
                    $max_tbl_id[$val] = $this->getMaxId($tempval,"id");
                    $this->session->set_userdata('max_'.$val.'_id', $max_tbl_id[$val]);
                }
            }
        }
    }
    function getMaxId($tbl_name,$id){
        $max_id = $this->db->query("SELECT max(".$id.") as max_id FROM smartboard_prod.".$tbl_name)->row_array();
        $max_id = $max_id['max_id'];
        $max_id = $this->setRound($max_id);
        return $max_id;
    }
    function getTblname()
    {
        $str = "SHOW TABLES";
        $result = $this->db->query($str);
        if ($result->num_rows() > 0){
            $list = $result->result_array();
            return $list;
        }
    }
    function transferTbl($tbl_name,$account_id=null,$franchise_id=null)
    {
        $rule = array();
        if(array_key_exists($tbl_name, $this->rules))
            $rule = $this->rules[$tbl_name];
        else if(in_array($tbl_name, $this->rules['normal_import']))
            $rule = array();
        else if (in_array($tbl_name, $this->rules['account_plus']))
            $rule = array('account_id'=>0);
        else
          return;
        $r = $this->hasColumn($tbl_name);
        if ($r->num_rows() == 0)
            $this->addField($tbl_name);
        if ($account_id !=null){
            if ($this->hasId($tbl_name,$account_id,"accounts")->num_rows() > 0)
                return;
        }
        else if ($franchise_id !=null){
            if ($this->hasId($tbl_name,$franchise_id,"franchises")->num_rows() > 0)
                return;
        }
        else{
            if ($this->hasId($tbl_name)->num_rows() > 0)
                return;
        }
        $max_franchise_id = $this->getMaxId('franchises', 'id');
        $str = "SHOW COLUMNS FROM ". $tbl_name;
        $result = $this->db->query($str);
        if ($result->num_rows() > 0){
            $list = $result->result_array();
            $fields = array();
            $dfields = array();
            $temp_tbl_name = $tbl_name;
            if($tbl_name == "email_configs")
                $temp_tbl_name = "email_settings";
            //$max_id = $this->db->query("SELECT max(id) as max_id FROM smartboard_prod.".$tbl_name." WHERE old_id is null")->row_array();
            $max_id = $this->db->query("SELECT max(id) as max_id FROM smartboard_prod.".$temp_tbl_name." WHERE old_id is null")->row_array();
            $max_id = $max_id['max_id'];
            foreach ($list as $key => &$value) {
                if ($tbl_name == "leads") {
                    if ($value["Field"] == "solar_nexus_id" || $value["Field"] == "solar_nexus_tracked" || $value["Field"] == "ccreated" || $value["Field"] == "infertemp_id")
                        continue;
                    array_push($fields, $value["Field"]);                        
                }
                else if ($tbl_name == "metrics_proposals" || $tbl_name == "metrics_installs" || $tbl_name == "metrics_finals" ){
                    if ($value["Field"] == "1st_period_in_months" || $value["Field"] == "standard_pmnt_1st_period" || $value["Field"] == "standard_pmnt_2nd_period" || $value["Field"] == "smart_pmnt_2nd_period" || $value["Field"] == "smarter_pmnt_2nd_period" || $value["Field"] == "deposit_payment_1" || $value["Field"] == "deposit_payment_2" || $value["Field"] == "final_payment" || $value["Field"] == "old_utility_bill" || $value["Field"] == "est_new_utility_bill" || $value["Field"] == "net_monthly_savings" || $value["Field"] == "utility_pre_solar_connect_fee" || $value["Field"] == "utility_pre_solar_rate_plan" || $value["Field"] == "utility_pre_solar_rep")
                        continue;
                    array_push($fields, $value["Field"]);
                }
                else
                    array_push($fields, $value["Field"]);
            }
            array_push($fields , "old_id");
            //$sql = "INSERT INTO smartboard_prod.".$tbl_name."(";
            $sql = "INSERT INTO smartboard_prod.".$temp_tbl_name."(";
            foreach ($fields as $field => $val) {
                $sql .=($field == 0 ? '' : ',')."`".$val."`";
            }
            $sql .=")(SELECT ";
            foreach ($fields as $field => $val) {
                $val_field = "`".$val."`";
                if ($val == "id")
                    $val_field = "id+".$this->setRound($max_id)." as id";
                else if($val == "old_id")
                    $val_field = "id as old_id";
                else if(isset($rule[$val]) && is_integer($rule[$val])){
                    if ($tbl_name == "custom_lead_fields"){
                        if ($val == "account_id")
                            $val_field = 0;
                        else if ($val == "active")
                            $val_field = 1;
                    }
                    else
                    {
                        if($val == "sales_owner")
                            $rule[$val] = '10000';
                        else
                            $rule[$val] = $this->session->userdata("max_".explode("_id", $val)[0]."s"."_id");
                        $val_field .= "+".$rule[$val]." as `".$val."`";
                    }
                }
                else if(isset($rule[$val]) && is_string($rule[$val]))
                    $val_field .= " as `".$rule[$val]."`";
                $sql .=$val_field;
                if ($field != count($fields)-1)
                    $sql .= ",";
            }
            if ( $tbl_name == "disposition_types" ){
                $id_str = "SELECT a.id FROM disposition_types as a LEFT JOIN smartboard_prod.disposition_types as b ON a.id = b.id WHERE b.id is null GROUP BY a.id";
                $id_query = $this->db->query($id_str);
                $sql .=" FROM ".$tbl_name." as a ";
                if ($id_query->num_rows()>0){
                    $sql .="WHERE ";
                    $id_list = $id_query->result_array();
                    foreach ($id_list as $k => $id) {
                        $sql .=" a.id = ".$id["id"];
                        if ($k != count($id_list) -1 )
                            $sql .=" OR ";
                    }
                }
            }
            // else if ( $tbl_name == "users" ){
            //     $sql .=" FROM ".$tbl_name;
            //     $sql .=" WHERE id NOT IN (SELECT a.id FROM users AS a,smartboard_prod.users AS b WHERE a.email = b.email)";
            // }
            else 
                $sql .=" FROM ".$tbl_name."";
            if ($account_id !=null){
                if ($tbl_name != "accounts"){
                    if ($tbl_name == "franchises")
                        $sql .=" WHERE  id in (SELECT franchise_id from franchise_accounts WHERE account_id = ". $account_id .")";
                    else
                        $sql .=" WHERE account_id = ".$account_id;
                }
                else
                    $sql .=" WHERE id = ".$account_id;
            }
            if ($franchise_id !=null){
                if ($tbl_name != "franchises")
                    if ($tbl_name == "accounts")
                        $sql .=" WHERE  id in (SELECT account_id from franchise_accounts WHERE franchise_id = ". $franchise_id .")";                        
                    else
                        $sql .=" WHERE  account_id in (SELECT account_id from franchise_accounts WHERE franchise_id = ". $franchise_id .")";                        
                        // $sql .=" WHERE franchise_id = ".$franchise_id;
                else
                    $sql .=" WHERE id = ".$franchise_id;
            }
            $sql .=" ) ";
            $this->db->query($sql);
            if ($account_id != null){
                if ($tbl_name == "milestones"){
                    $milestones_sql = "INSERT INTO smartboard_prod.franchise_milestones (
                                            franchise_id,
                                            milestone_id
                                        )(
                                            SELECT
                                                c.franchise_id+".$max_franchise_id.",b.id
                                            FROM
                                                milestones AS a,
                                                smartboard_prod.milestones AS b,
                                                franchise_accounts AS c
                                            WHERE
                                                a.id = b.old_id
                                            AND c.account_id = a.account_id
                                            AND a.account_id = ".$account_id."
                                        )";
                    $this->db->query($milestones_sql);
                    $this->write($this->db->last_query()."\n\r");
                    $path_sql = "INSERT INTO smartboard_prod.paths (name,is_lead_path,account_id,is_active,is_default,parent_id,is_used)(
                                    SELECT
                                        CONCAT(
                                            b.primary_customer_name,
                                            ',',
                                            b.id
                                        ) AS NAME,
                                        1 AS is_lead_path,
                                        b.account_id,
                                        1,
                                        1,
                                        0,
                                        0
                                    FROM
                                        leads AS a,
                                        smartboard_prod.leads AS b
                                    WHERE
                                        a.id = b.old_id
                                    AND a.account_id = ".$account_id."
                                )" ;
                    $this->db->query($path_sql);
                    $this->write($this->db->last_query()."\n\r");
                    $path_item_sql = "INSERT INTO smartboard_prod.path_items(milestone_id,path_id,`order`)(
                                        SELECT
                                            a.id AS milestone_id,
                                            b.id AS path_id,a.`order`
                                        FROM
                                            smartboard_prod.milestones AS a
                                        LEFT JOIN smartboard_prod.paths AS b ON b.account_id = a.account_id
                                        INNER JOIN milestones AS c ON a.old_id = c.id
                                        WHERE
                                            c.account_id = ".$account_id."
                                      )";
                    $this->db->query($path_item_sql);
                    $this->write($this->db->last_query()."\n\r");
                    // $this->write($milestones_sql."\n\r");
                }
            }
            // $this->write($sql."\n\r");

        }
    }

    function updateSST($franchise_id){
        $franchise_max_id = $this->getMaxId('franchises', 'id');
        //report_settings
        $this->db->insert('smartboard_prod.`report_settings`', array(
            'franchise_id'             => $franchise_id + $franchise_max_id,
            'view_report_roles'         => '[\"1\",\"2\",\"3\"]',
            'view_detailed_roles'       => '[\"1\",\"2\",\"3\"]',
            'view_all_customer_roles'   => '[\"1\",\"2\",\"3\"]',
            'view_public_roles'         => '[\"1\",\"2\",\"3\"]',
            'edit_public_roles'         => '[\"1\",\"2\",\"3\"]',
            'view_report_positions'     => null,
            'view_detailed_positions'   => null,
            'view_duration_roles'       => '[\"1\",\"2\",\"3\"]',
            'view_all_customer_positions' => null,
            'view_public_positions'     => null,
            'edit_public_positions'     => null,
            'view_duration_positions'   => null,
            'edit_duration_positions'   => null,
        ));

        //teams
        $team_sql = "INSERT INTO smartboard_prod.teams (`id`, `name`, `order`, `franchise_id`)
            (
                SELECT 0 as `id`, b.`business_name` as `name`, 0 as `order`, (a.`franchise_id` + " . $franchise_max_id . ") as `franchise_id`
                FROM franchise_accounts a
                LEFT JOIN accounts b on a.account_id = b.id
                WHERE a.franchise_id = " . $franchise_id . "
            )";
        $this->db->query($team_sql);

        $milestone_max_id = $this->getMaxId('milestones', 'id');
        //whiteboard_groups
        $whiteboard_sql = 'INSERT INTO smartboard_prod.whiteboard_groups (`id`, `name`, `franchise_id`, `associated_ids`, `sequence`, `limit_in_days`, `overdue_color`, `due_today_color`, `on_hold_color`, `on_hold_name`)
            (
                SELECT 0 as `id`, "All" as `name`, 
                        a.franchise_id + ' . $franchise_max_id . ' as `franchise_id`, 
                        CONCAT("[", GROUP_CONCAT("\"", b.id + ' . $milestone_max_id . ', "\""), "]") as `associated_ids`, 1 as `sequence`, 0 as `limit_in_days`, "#c00" as `overdue_color`, "#ffd966" as `due_today_color`, "#9fc5e8" as `on_hold_color`, "On Hold" as `on_hold_name`
                FROM franchise_accounts a, milestones b
                WHERE a.franchise_id = ' . $franchise_id . ' and a.account_id = b.account_id
                GROUP BY a.franchise_id
            )';
        $this->db->query($whiteboard_sql);
        //whiteboard_group_positions
        $sb_franchise_id = $franchise_id + $franchise_max_id;
        $whiteboard_max_id = $this->getMaxId('whiteboard_group_positions', 'id');
        $whiteboard_group_positions_sql = 'INSERT INTO smartboard_prod.whiteboard_group_positions(`id`,`whiteboard_group_id`,`position_id`)
            (SELECT c.ID, c.whiteboard_group_id, c.position_id FROM
                (SELECT @rowid:='. $whiteboard_max_id .', @rowid:=@rowid + 1 AS ID, a.id AS whiteboard_group_id, b.position_id FROM smartboard_prod.whiteboard_groups a,
                        (
                            SELECT
                                1 AS position_id
                            UNION ALL
                            SELECT
                                2 AS position_id
                             UNION ALL
                            SELECT
                                3 AS position_id
                            UNION ALL
                            SELECT
                                5 AS position_id
                            UNION ALL
                            SELECT
                                6 AS position_id
                            UNION ALL
                            SELECT
                                7 AS position_id
                            UNION ALL
                            SELECT
                                8 AS position_id
                            UNION ALL
                            SELECT
                                9 AS position_id
                            UNION ALL
                            SELECT
                                10 AS position_id
                            UNION ALL
                            SELECT
                                11 AS position_id
                            UNION ALL
                            SELECT
                                12 AS position_id
                            UNION ALL
                            SELECT
                                13 AS position_id
                            UNION ALL
                            SELECT
                                14 AS position_id
                            UNION ALL
                            SELECT
                                15 AS position_id
                            UNION ALL
                            SELECT
                                16 AS position_id
                            UNION ALL
                            SELECT
                                17 AS position_id
                            UNION ALL
                            SELECT
                                18 AS position_id
                            UNION ALL
                            SELECT
                                19 AS position_id
                            UNION ALL
                            SELECT
                                20 AS position_id
                            UNION ALL
                            SELECT
                                21 AS position_id
                            UNION ALL
                            SELECT
                                22 AS position_id
                        ) b
                    WHERE
                        a.franchise_id = 9
                    ORDER BY whiteboard_group_id, position_id) c
            )';
        $this->db->query($whiteboard_group_positions_sql);

    }
    function addField($tbl_name)
    {
        if($tbl_name == "email_configs")
            $tbl_name = "email_settings";
        if ($tbl_name == "appointments"){
            $sql = "SHOW COLUMNS FROM smartboard_prod.`".$tbl_name."` LIKE 'appointment_status_id'";
            if ($this->db->query($sql)->num_rows() > 0 )
                $alter="ALTER TABLE smartboard_prod.".$tbl_name." ADD COLUMN `old_id` int(11)";
            else
                $alter="ALTER TABLE smartboard_prod.".$tbl_name." ADD COLUMN `appointment_status_id` INT(3) ,ADD COLUMN `old_id` int(11)";
        }
        elseif ($tbl_name == "customers")
            $alter="ALTER TABLE smartboard_prod.".$tbl_name." ADD COLUMN `old_id` int(11),ADD COLUMN `primary_phone` varchar(20), ADD COLUMN `secondary_phone` varchar(20)";
        elseif ($tbl_name == "commission_rules")
            $alter="ALTER TABLE smartboard_prod.".$tbl_name." ADD COLUMN `old_id` int(11),ADD COLUMN `action_count` int(3), ADD COLUMN `time_frame_id` int(11) ,ADD COLUMN `time_frame_length` int(3),ADD COLUMN `lead_generation_type_id` int(11)";
        elseif ($tbl_name == "custom_positions")
            $alter="ALTER TABLE smartboard_prod.".$tbl_name." ADD COLUMN `old_id` int(11),ADD COLUMN `account_id` int(11)";
        else
            $alter="ALTER TABLE smartboard_prod.".$tbl_name." ADD COLUMN `old_id` int(11)";
        $this->db->query($alter);
    }
    function delField($tbl_name)
    {
        if($tbl_name == "email_configs")
            $tbl_name = "email_settings";
        $table_sql = "SHOW TABLES FROM smartboard_prod LIKE '".$tbl_name."'";
        $r = $this->db->query($table_sql);
        if ($r->num_rows() > 0){
            $result = $this->hasColumn($tbl_name);
            if ($result->num_rows() > 0){
                if ($tbl_name == 'custom_positions') 
                    $alter=" ALTER TABLE `smartboard_prod`.`custom_positions` DROP COLUMN `account_id`,DROP COLUMN `old_id`";
                elseif ($tbl_name == "customers")
                    $alter=" ALTER TABLE `smartboard_prod`.`customers` DROP COLUMN `primary_phone`,DROP COLUMN `secondary_phone`,DROP COLUMN `old_id`";
                elseif ($tbl_name == 'commission_rules') 
                    $alter=" ALTER TABLE `smartboard_prod`.`commission_rules` DROP COLUMN `old_id`,DROP COLUMN `action_count`, DROP COLUMN `time_frame_id`, DROP COLUMN `time_frame_length`, DROP COLUMN `lead_generation_type_id`";
                else
                    $alter="ALTER TABLE `smartboard_prod`.`".$tbl_name."` DROP COLUMN `old_id`";
                $this->db->query($alter);
            }
        }
    }
    function hasColumn($tbl_name)
    {
        if($tbl_name == "email_configs")
            $tbl_name = "email_settings";
        $sql = "SHOW COLUMNS FROM smartboard_prod.`".$tbl_name."` LIKE 'old_id'";
        return $this->db->query($sql);
    }
    function hasId($tbl_name,$id=null,$type=null)
    {
        $temp_tbl_name = $tbl_name;
        if($tbl_name == "email_configs")
            $temp_tbl_name = "email_settings";
        //$sql = "SELECT a.id FROM ".$tbl_name." as a INNER JOIN smartboard_prod.".$tbl_name." as b ON a.id = b.old_id";
        $sql = "SELECT a.id FROM ".$tbl_name." as a INNER JOIN smartboard_prod.".$temp_tbl_name." as b ON a.id = b.old_id";
        if ($type =="accounts"){
            if ($tbl_name != "accounts"){
                if ($tbl_name == "franchises")
                    $sql .=" WHERE  a.id in (SELECT franchise_id from franchise_accounts WHERE account_id = ". $id .")";
                else
                    $sql .=" WHERE a.account_id = ".$id;
            }
            else
                $sql .=" WHERE a.id = ".$id;
        }
        if ($type =="franchises"){
            if ($tbl_name != "franchises")
                if ($tbl_name == "accounts")
                    $sql .=" WHERE  a.id in (SELECT account_id from franchise_accounts WHERE franchise_id = ". $id .")";                        
                else
                    $sql .=" WHERE  a.account_id in (SELECT account_id from franchise_accounts WHERE franchise_id = ". $id .")";                        
            else
                $sql .=" WHERE a.id = ".$id;
        }
        // $this->merge_model->write($sql."\n\r");
        return $this->db->query($sql);
    }
    function updateTbl($tbl_name)
    {
        if($tbl_name == "email_configs")
            $tbl_name = "email_settings";
        $table_sql = "SHOW TABLES FROM smartboard_prod LIKE '".$tbl_name."'";
        $r = $this->db->query($table_sql);
        if ($r->num_rows() > 0){
            $re = $this->hasColumn($tbl_name);
            if ($re->num_rows() > 0){
                if ($tbl_name == "appointments"){
                    for ($i = 1; $i < 19; $i++){
                        $this->appointments_update($i);
                    }
                }
                else if ($tbl_name == "actions" || $tbl_name == "activities" || $tbl_name == "documents" || $tbl_name == "document_templates" || $tbl_name == "leads_milestones" || $tbl_name == "leads_milestones_conditions" || $tbl_name == "lead_notes" || $tbl_name == "milestone_alerts" ){
                    $this->db->set('created','DATE_ADD(created, INTERVAL 6 HOUR)',false);
                    $this->db->where('old_id is not ','NULL', false);
                    $this->db->where('created > ','"2019-09-01 00:00:00"', false);
                    $this->db->update("smartboard_prod.".$tbl_name);
                }
                elseif ($tbl_name == "configs") {
                    # code...
                    $this->db->set('use_ignite', 1);
                    $this->db->set('force_ignite_leads', 0);
                    $this->db->set('training_account', 0);
                    $this->db->set('use_solo', 0);
                    $this->db->where('old_id is not ','NULL', false);
                    $this->db->update("smartboard_prod.".$tbl_name);
                    $business_start_time = "TIME_FORMAT(
                                                time(
                                                    DATE_ADD(
                                                        STR_TO_DATE(REPLACE (business_start_time, ' ', ''),'%h:%i%p'),
                                                        INTERVAL
                                                        6 HOUR
                                                    )
                                                )
                                            ,'%h:%i%p')";
                    $business_end_time = "TIME_FORMAT(
                                                time(
                                                    DATE_ADD(
                                                        STR_TO_DATE(REPLACE (business_end_time, ' ', ''),'%h:%i%p'),
                                                        INTERVAL
                                                        6 HOUR
                                                    )
                                                )
                                            ,'%h:%i%p')";
                    $this->db->set('business_start_time',$business_start_time,false);
                    $this->db->set('business_end_time',$business_end_time,false);
                    $this->db->where('old_id is not ','NULL', false);
                    $this->db->where('business_start_time != ','""', false);
                    $this->db->where('business_end_time != ','""', false);
                    $this->db->update("smartboard_prod.".$tbl_name);
                }
                else if ($tbl_name == "events"){
                    $start_date = "date(
                                        DATE_ADD(
                                            DATE_ADD(
                                                TIMESTAMP (
                                                    CONCAT(
                                                        start_date,
                                                        ' ',
                                                        REPLACE (start_time, ' ', '')
                                                    )
                                                ),
                                                INTERVAL
                                            IF (
                                                lower(start_time) LIKE '%pm%',
                                                12,
                                                0
                                            ) HOUR
                                            ),
                                            INTERVAL 6 HOUR
                                        )
                                    )";
                    $start_time = "TIME_FORMAT(
                                    time(
                                        DATE_ADD(
                                            DATE_ADD(
                                                TIMESTAMP (
                                                    CONCAT(
                                                        start_date,
                                                        ' ',
                                                        REPLACE (start_time, ' ', '')
                                                    )
                                                ),
                                                INTERVAL
                                            IF (
                                                lower(start_time) LIKE '%pm%',
                                                12,
                                                0
                                            ) HOUR
                                            ),
                                            INTERVAL 6 HOUR
                                        )
                                    ),'%h:%i%p')";
                    $end_date = "date(
                                        DATE_ADD(
                                            DATE_ADD(
                                                TIMESTAMP (
                                                    CONCAT(
                                                        end_date,
                                                        ' ',
                                                        REPLACE (end_time, ' ', '')
                                                    )
                                                ),
                                                INTERVAL
                                            IF (
                                                lower(end_time) LIKE '%pm%',
                                                12,
                                                0
                                            ) HOUR
                                            ),
                                            INTERVAL 6 HOUR
                                        )
                                    )";
                    $end_time = "TIME_FORMAT(
                                    time(
                                        DATE_ADD(
                                            DATE_ADD(
                                                TIMESTAMP (
                                                    CONCAT(
                                                        end_date,
                                                        ' ',
                                                        REPLACE (end_time, ' ', '')
                                                    )
                                                ),
                                                INTERVAL
                                            IF (
                                                lower(end_time) LIKE '%pm%',
                                                12,
                                                0
                                            ) HOUR
                                            ),
                                            INTERVAL 6 HOUR
                                        )
                                    ),'%h:%i%p')";
                    $this->db->set('start_date',$start_date,false);
                    $this->db->set('start_time',$start_time,false);
                    $this->db->set('end_date',$end_date,false);
                    $this->db->set('end_time',$end_time,false);
                    $this->db->where('old_id is not ','NULL', false);
                    $this->db->where('start_date > ','"2019-09-01 00:00:00"', false);
                    $this->db->where('end_date > ','"2019-09-01 00:00:00"', false);
                    $this->db->update("smartboard_prod.".$tbl_name);
                }
                elseif ($tbl_name == "disposition_types") {
                    # code...
                    $this->db->where('old_id is not ','NULL', false);
                    $this->db->select('*');
                    $result=$this->db->get('smartboard_prod.'.$tbl_name);
                    $result = $result->result_array();
                    $order = 35;
                    foreach ($result as $key => $value) {
                        # code...
                        $this->db->where('id =',$value['id']);
                        $this->db->set('display', 1);
                        $this->db->set('order', $order);
                        $this->db->set('active', 1);
                        $this->db->update("smartboard_prod.".$tbl_name);
                        $order++;
                    }
                }
                elseif ($tbl_name == "franchise_user_permissions"){
                    $this->db->where('old_id is not ','NULL', false);
                    $this->db->select('*');
                    $result=$this->db->get('smartboard_prod.'.$tbl_name);
                    $result = $result->result_array();
                    foreach ($result as $row) {
                        # code...
                        $accounts = $row['accounts'];
                        $pattern = array('[', ']', '"', "{", "}", "Accounts", ":");
                        $accounts_str = str_replace($pattern, "", $accounts);

                        $accounts_list = explode("," ,$accounts_str);
                        $new_accounts = '[';
                        foreach ($accounts_list as $index => $value) {

                            $new_accounts .= ($index == 0 ? '' : ',') . '"' . ($value + 20000) . '"';
                        }
                        $new_accounts .= ']';
                        $this->db->where('id =',$row['id']);
                        $this->db->set('accounts', $new_accounts);
                        $this->db->update("smartboard_prod.".$tbl_name);
                    }
                }
                else if ($tbl_name == "leads"){
                    $this->db->set('created','DATE_ADD(created, INTERVAL 6 HOUR)',false);
                    $this->db->where('old_id is not ','NULL', false);
                    $this->db->where('created > ','"2019-09-01 00:00:00"', false);
                    $this->db->update("smartboard_prod.".$tbl_name);
                    $this->db->where('old_id is not ','NULL', false);
                    $this->db->set('preferred_contact_type_id', 1);
                    $this->db->set('notification_sent', 0);
                    $this->db->set('on_hold_sent', 0);
                    $this->db->set('service_fusion', 0);
                    $this->db->set('preferred_languages_id', 1);
                    $this->db->set('associated_app_id', 1);
                    $this->db->set('associated_id', 0);
                    $this->db->update("smartboard_prod.".$tbl_name);
                }
                else if ($tbl_name == "lead_dispositions"){
                    $this->db->set('`date`','DATE_ADD(`date`, INTERVAL 6 HOUR)',false);
                    $this->db->where('old_id is not ','NULL', false);
                    $this->db->where('`date` > ','"2019-09-01 00:00:00"', false);
                    $this->db->update("smartboard_prod.".$tbl_name);
                }
                elseif ($tbl_name == "lead_images") {
                    # code...
                    $this->db->where('old_id is not ','NULL', false);
                    $this->db->set('tab_id', 1);
                    $this->db->update("smartboard_prod.".$tbl_name);
                }
                elseif ($tbl_name == "lead_image_types") {
                    $this->db->where('old_id is not ','NULL', false);
                    $this->db->select('old_id');
                    $result=$this->db->get('smartboard_prod.'.$tbl_name);
                    $result = $result->result_array();
                    $count = 1;
                    foreach ($result as $key => $value) {
                        $update = "UPDATE smartboard_prod.".$tbl_name." SET active=1,`order`=".$count." WHERE old_id=".$value['old_id'];
                        $this->db->query($update);
                        $count++;
                    }
                }
                elseif ($tbl_name == "metrics_proposals" || $tbl_name == "metrics_installs" || $tbl_name == "metrics_finals") {
                    # code...
                    $this->db->where('old_id is not ','NULL', false);
                    $this->db->set('proposal_id', 0);
                    $this->db->set('locked', 0);
                    $this->db->update("smartboard_prod.".$tbl_name);
                }
                else if ($tbl_name == "sales"){
                    $this->db->set('`disposition_date`','DATE_ADD(`disposition_date`, INTERVAL 6 HOUR)',false);
                    $this->db->set('`created`','DATE_ADD(`created`, INTERVAL 6 HOUR)',false);
                    $this->db->where('old_id is not ','NULL', false);
                    $this->db->update("smartboard_prod.".$tbl_name);
                }
            }
        }
    }
    function write($str){
        $fp = fopen("log.txt", "a");
        fwrite($fp, $str);
        fclose($fp);
    }
    function appointments_update($type){
                switch ($type) {
                    case 1:
                    case 2:
                            $this->db->set('appointment_status_id', 1);
                        break;
                    case 3:
                    case 7:
                    case 17:
                            $this->db->set('appointment_type_id', 1);
                            $this->db->set('appointment_status_id', 4);
                        break;
                    case 4:
                    case 11:
                    case 13:
                    case 14:
                            $this->db->set('appointment_type_id', 1);
                            $this->db->set('appointment_status_id', 1);
                        break;
                    case 5:
                    case 15:
                            $this->db->set('appointment_type_id', 2);
                            $this->db->set('appointment_status_id', 1);
                        break;
                    case 6:
                    case 16:
                            $this->db->set('appointment_type_id', 1);
                            $this->db->set('appointment_status_id', 2);
                        break;
                    case 8:
                    case 18:
                            $this->db->set('appointment_type_id', 1);
                            $this->db->set('appointment_status_id', 3);
                        break;
                    case 12:
                            $this->db->set('appointment_type_id', 3);
                            $this->db->set('appointment_status_id', 1);
                        break;
                    default:
                            return;
                        break;
                }
                $this->db->where('appointment_type_id',$type);
                $this->db->where('old_id is not ','NULL', false);
                $this->db->update("smartboard_prod.appointments");
    }
    function setRound($id)
    {   
//        $first = intval(substr($id, 0, 1))+1;
//        $second = intval(substr($id, 1, 1));
        $round = "1";//$first;
        for($i = 0; $i < strlen($id); $i++){
//            if($i == 0 && strlen($id) >= 3 && $second >= 8)
//                $round .= "1";
//            else
                $round .= "0";
        }
        return $round;
    }
    function getAccount()
    {
        $result = $this->db->get("accounts")->result_array();
        return $result;
    }
    function getFranchise()
    {
        $result = $this->db->get("franchises")->result_array();
        return $result;
    }
}