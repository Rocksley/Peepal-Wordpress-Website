<?php

class FMControllerUninstall_fm extends FMAdminController {
  private $model;
  private $view;
  private $addons = array(
    'WD_FM_MAILCHIMP' => 'mailchimp',
    'WD_FM_REG' => 'reg',
    'WD_FM_POST_GEN' => 'post_gen_options',
    'WD_FM_EMAIL_COND' => 'email_conditions',
    'WD_FM_DBOX_INT' => 'dbox_int',
    'WD_FM_GDRIVE_INT' => 'formmaker_gdrive_int',
    'WD_FM_PDF' => array( 'pdf_options', 'pdf' ),
    'WD_FM_PUSHOVER' => 'pushover',
    'WD_FM_SAVE_PROG' => array( 'save_options', 'saved_entries', 'saved_attributes' ),
    'WD_FM_STRIPE' => 'stripe',
    'WD_FM_CALCULATOR' => 'calculator',
  );

  public function __construct() {
    require_once WDFMInstance(self::PLUGIN)->plugin_dir . "/admin/models/Uninstall_fm.php";
    $this->model = new FMModelUninstall_fm();
    require_once WDFMInstance(self::PLUGIN)->plugin_dir . "/admin/views/Uninstall_fm.php";
    $this->view = new FMViewUninstall_fm();
    if ( WDFMInstance(self::PLUGIN)->is_free ) {
      global $fm_options;
      global $cfm_options;
      if ( !class_exists("DoradoWebConfig") ) {
        include_once(WDFMInstance(self::PLUGIN)->plugin_dir . "/wd/config.php");
      }
      $config = new DoradoWebConfig();
      $config->set_options(WDFMInstance(self::PLUGIN)->is_free == 1 ? $fm_options : $cfm_options);
      $deactivate_reasons = new DoradoWebDeactivate($config);
      $deactivate_reasons->submit_and_deactivate();
    }
  }

  public function execute() {
    $task = ((isset($_POST['task'])) ? esc_html(stripslashes($_POST['task'])) : '');
    if ( method_exists($this, $task) ) {
      check_admin_referer(WDFMInstance(self::PLUGIN)->nonce, WDFMInstance(self::PLUGIN)->nonce);
      $this->$task();
    }
    else {
      $this->display();
    }
  }

  public function display() {
    $params = array();
    $params['addons'] = $this->addons;
    $params['page_title'] = sprintf(__('Uninstall %s', WDFMInstance(self::PLUGIN)->prefix), WDFMInstance(self::PLUGIN)->nicename);
    $params['tables'] = $this->get_tables();
    global $wpdb;
    foreach ( $params['addons'] as $addon => $addon_name ) {
      if ( is_array($addon_name) ) {
        // If there are more than one db tables in an extension.
        foreach ( $addon_name as $ad_name ) {
          array_push($params['tables'], $wpdb->prefix . 'formmaker_' . $ad_name);
        }
      }
      else {
        array_push($params['tables'], $wpdb->prefix . 'formmaker_' . $addon_name);
      }
    }
    $this->view->display($params);
  }

  /**
   * Return DB tables names.
   *
   * @return array
   */
  private function get_tables() {
    global $wpdb;
    $tables = array(
      $wpdb->prefix . 'formmaker',
      $wpdb->prefix . 'formmaker_backup',
      $wpdb->prefix . 'formmaker_blocked',
      $wpdb->prefix . 'formmaker_groups',
      $wpdb->prefix . 'formmaker_submits',
      $wpdb->prefix . 'formmaker_views',
      $wpdb->prefix . 'formmaker_themes',
      $wpdb->prefix . 'formmaker_sessions',
      $wpdb->prefix . 'formmaker_query',
      $wpdb->prefix . 'formmaker_display_options',
    );

    return $tables;
  }

  public function uninstall() {
    $params['tables'] = $this->get_tables();
    $this->model->delete_db_tables();

    // Deactivate all extensions and form maker.
    WDW_FM_Library(self::PLUGIN)->deactivate_all_addons(WDFMInstance(self::PLUGIN)->main_file);

    wp_redirect(admin_url('plugins.php'));
    exit();
  }
}
