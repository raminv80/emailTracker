<?php
namespace App;

class PixelTrracker {
    const TABLE_PIXEL_TRACKER = 'emails';

    function create($email, $subject, $message) {
        // generate unique token
        $token = $this->getToken();

        // record it into db
        \DB::insert(self::TABLE_PIXEL_TRACKER, array(
            'subject'=> $subject,
            'email'=> $email,
            'token'=> $token,
            'body'=>$message,
            'created_at'=> date("Y-m-d H:i:s")
        ));

        return $token;
    }

    function recordView($token) {
        // find the record in db
        $email = \DB::queryFirstRow("SELECT id, views FROM ".self::TABLE_PIXEL_TRACKER." WHERE token = %s ", $token);
        if($email){
            // mark it as visited
            // increase the views
            \DB::update(self::TABLE_PIXEL_TRACKER, [
                'seen' => 1,
                'views' => $email['views']+1
            ], 'id=%s', $email['id']);
        }
    }

    function getAll(){
        // return all emails
        return \DB::query("SELECT * FROM ".self::TABLE_PIXEL_TRACKER." ORDER BY ID DESC");
    }

    private function getToken(){
        do {
            $token = uniqid();
            $res = \DB::query("SELECT count(id) as duplicates FROM ".self::TABLE_PIXEL_TRACKER." WHERE token = %s ", $token);
        }while((int)$res[0]['duplicates']>0);

        return $token;
    }

    function to_csv_download($filename = "export.csv", $delimiter=";") {
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        // open the "output" stream
        // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
        $f = fopen('php://output', 'w');

        foreach ($this->getAll() as $line) {
            fputcsv($f, $line, $delimiter);
        }
    }
}
