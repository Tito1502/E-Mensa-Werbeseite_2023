<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/kategorie.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/gericht.php');

class ExampleController
{
    public function m4_7a_queryparameter(RequestData $rd): string
    {
        /*
           Wenn Sie hier landen:
           bearbeiten Sie diese Action,
           so dass Sie die Aufgabe löst
        */
        $vars = [
            'name' => $rd->query['name'] ?? '',
            'rd' => $rd
        ];

        return view('examples.m4_7a_queryparameter', $vars);

        /*
        return view('notimplemented', [
            'request'=>$rd,
            'url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"
        ]);*/
    }

    public function m4_7b_kategorie(): string
    {
        $data = db_kategorie_sort_acs();


        return view('examples.m4_7b_kategorie', ['data' => $data]);

    }

    public function m4_7c_gerichte(): string
    {
        $data = db_gericht_sort_price_desc();

        return view('examples.m4_7c_gerichte', ['data' => $data]);

    }

    public function m4_7d_layout(RequestData $rd): string
    {

        $no = $rd->query['no'] ?? 1;

        if ($no == 2) {
            return view('examples.pages.m4_7d_page_2');
        }

        return view('examples.pages.m4_7d_page_1');
    }


}