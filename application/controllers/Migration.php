<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CI Migration
 *
 * Author       : ideaLana
 * URI          : https://github.com/idealana/ci-migration/
 * Version      : 1.0.0
 * Created Date : 2022-10-26
 */
class Migration extends CI_Controller {
	/**
	 * Path to migration classes
	 * @var string
	 */
	private $_migration_path = APPPATH.'migrations/';

	/**
	 * Database table with migration info
	 * @var string
	 */
	private $_migration_table = 'migrations';

	/**
	 * Naming migration class
	 * @var string
	 */
	private $_migration_name;

	/**
	 * Line break type according by user request
	 * @var mix
	 */
	private $_line_break;

	/**
	 * Token
	 * @var string
	 */
	private $_token = 'CI3_Migration';

	/**
	 * Initialize
	 */
	public function __construct()
	{
		parent::__construct();

		$token = $this->input->get('t', TRUE);
		if(empty($token) || $token !== $this->_token) exit;

		if(! property_exists($this, 'db')) {
			echo "Please load your library 'database' in config/autoload.php";
			exit;
		}

		$this->_line_break = $this->input->is_cli_request() ? PHP_EOL : '<br>';
		$this->load->library('migration');
	}

	/**
	 * Migrate to the latest migration
	 */
	public function migrate()
	{
		$hasMigrate = false;
		$current_version = $this->_get_version();

		foreach ($this->migration->find_migrations() as $version => $file) {
			if($version <= $current_version) continue;

			echo "Migrating ".basename($file, '.php').$this->_line_break;
			$hasMigrate = true;
		}

		if(false === $hasMigrate) {
			echo "Nothing to migrate";
			exit;
		}

		// run migration
		$this->migration->latest();
	}

	/**
	 * Rollback migration created today or start from specific version
	 */
	public function rollback($start_at = 0)
	{
		$has_rollback = false;
		$now = date('Ymd');
		$new_version = 0;
		$current_version = $this->_get_version();

		foreach ($this->migration->find_migrations() as $version => $file) {
			if($version > $current_version) continue;

			if($start_at > 0) {
				if($version < $start_at) {
					$new_version = $version;
					continue;
				}

			} else {
				if(date('Ymd', strtotime($version)) != $now) {
					$new_version = $version;
					continue;
				}
			}

			echo "Rollback ".basename($file, '.php').$this->_line_break;
			$has_rollback = true;
		}

		if(false === $has_rollback) {
			echo "Nothing to rollback";
			exit;
		}

		// run migration
		$this->migration->version($new_version);
	}

	/**
	 * Make migration file
	 * @param string $migration_name
	 */
	public function make($migration_name = '')
	{
		if(empty($migration_name)) {
			echo 'Please enter your migration name. php index.php migration make your_migration_name';
			exit;
		}

		// create migrations dir
		$this->_init_dir();

		// create migration file
		$this->_migration_name = str_replace(" ", "_", $migration_name);
		$timestamp = date('YmdHis');
		$fileName = $timestamp.'_'.$this->_migration_name;

		if(false === $this->_create_file($this->_migration_path.$fileName.'.php', $this->_template_migration())) {
			echo 'Migration '. $fileName .' does exist';
			exit;
		}

		echo 'Migration '. $fileName .' created';
	}

	/**
	 * Retrieves current schema version
	 * @return	string	Current migration version
	 */
	private function _get_version()
	{
		$row = $this->db->select('version')->get($this->_migration_table)->row();
		return $row ? $row->version : '0';
	}

	/**
	 * Initialize migration directory
	 */
	private function _init_dir()
	{
		// create dir
		if(! is_dir($this->_migration_path)) {
			mkdir($this->_migration_path, 0777, true);
		}
		// create index.html file
		$this->_create_file($this->_migration_path."index.html", $this->_template_index());
	}

	/**
	 * Create file
	 * @param string $filePath, string $template
	 * @return bool
	 */
	private function _create_file($filePath, $template = '') {
		if(file_exists($filePath)) return false;

		$file = fopen($filePath, "w");
		fwrite($file, $template);
		fclose($file);
		return true;
	}

	/**
	 * Template index file
	 * @return string
	 */
	private function _template_index()
	{
		return "<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>";
	}

	/**
	 * Template migration file
	 * @return string
	 */
	private function _template_migration()
	{
		$template = "<?php"."\n\n";

		$template .= "defined('BASEPATH') OR exit('No direct script access allowed');"."\n\n";
		
		$template .= "class Migration_".ucfirst(strtolower($this->_migration_name))." extends CI_Migration"."\n";
		$template .= "{"."\n";

		$template .= "\t"."public function up()"."\n";
		$template .= "\t"."{"."\n";
		$template .= "\t\t"."// create your schema table here..."."\n";
		$template .= "\t"."}"."\n\n";

		$template .= "\t"."public function down()"."\n";
		$template .= "\t"."{"."\n";
		$template .= "\t\t"."// schema rollback"."\n";
		$template .= "\t"."}"."\n";

		$template .= "}"."\n";

		return $template;
	}
}
