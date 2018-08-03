<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Jobs\Scrapmore;
use App\Scrapdata;
use Goutte;

class ScrapdataController extends Controller
{
    public function index() {

    	$this->layout = null;
    	$scrapdata = []; // balnk array to store scraped data
    	$i = 0;

    	try {

    		$crawler = Goutte::request('GET', 'http://readcomicsonline.ru');
    		$crawler->filter('.chart-title, a > img')->each(function ($node) use(&$i, &$scrapdata){

		      if($node->getNode(0)->nodeName == 'img') {

		      	$scrapdata[$i]['img_url'] = $node->getNode(0)->getAttribute('src');

		      } else {

		      	$scrapdata[$i]['name'] = $node->text();
		      	$scrapdata[$i]['related_url'] = $node->getNode(0)->getAttribute('href');
		      	$i++;
		      }

		    });

		    /* Add values into database */

		    if(isset($scrapdata) && !empty($scrapdata)) {

		       foreach($scrapdata as $val) {

		       		$scrap = new Scrapdata;

				    $scrap->name = $val['name'];
				    $scrap->related_url = $val['related_url'];
				    $scrap->img_url = $val['img_url'];
				    $scrap->created_at = date("Y-m-d h:i:s");
				    $scrap->updated_at = date("Y-m-d h:i:s");
				    $scrap->save();

				    $this->dispatch(new Scrapmore($scrap));
		       }
		    }

    	} catch(\Exception $ex) {

    		echo $ex->getMessage(); die("error");
    	}
    }
}
