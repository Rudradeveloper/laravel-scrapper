<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Scrapdata;
use Goutte;

class Scrapmore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $scrapval;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($scrapval)
    {
        $this->scrapval = $scrapval;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $scrap = []; // balnk array to store scraped data
        $i = 0;
        $crawler = Goutte::request('GET', $this->scrapval->related_url);
        $crawler->filter('#item-rating, p')->each(function ($node) use(&$i, &$scrap){

          if($node->getNode(0)->nodeName == 'p') {
            $scrap[$i]['summary'] = trim($node->text());
          } else {
            $scrap[$i]['raiting'] = trim($node->getNode(0)->getAttribute('data-score'));
            $i++;
          }

        });

        Scrapdata::where('id', $this->scrapval->id)->update(['related_details' => json_encode($scrap)]);

    }
}
