<?php

/**
 * Backup Controller
 *
 * Backup Controller manages backup of database.
 *
 * @category   Backup
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.7
 * @link       http://techvill.net
 * @email      support@techvill.net
 * @since      Version 1.3
 * @deprecated None
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\BackupsDataTable;
use App\Models\Backup;
use DB, Common;

class BackupController extends Controller
{

    public function index(BackupsDataTable $dataTable)
    {
        return $dataTable->render('admin.backups.view');
    }

    public function add(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
            $backup_name = Common::backup_tables(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'));
            if ($backup_name != 0) {
                DB::table('backups')->insert(['name' => $backup_name, 'created_at' => date('Y-m-d H:i:s')]);
                Common::one_time_message('success', 'Successfully saved');
            }
        }
        return redirect()->intended('admin/settings/backup');
    }

    public function download(Request $request)
    {
        $backup = Backup::find($request->id);
        $filename =  $backup->name;
        $backup_loc = url('storage/db-backups/'.$filename);
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");
        readfile($backup_loc);
        exit;
    }
}
