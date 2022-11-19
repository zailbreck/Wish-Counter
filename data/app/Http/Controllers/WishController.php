<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

use App\Models\WishCollection;
use mysql_xdevapi\Result;

class WishController extends Controller
{
    public function CountWishes(Request $request) {
        $resp = $this->countData();
        $s = array();
        $s = array_merge($s, $resp[0]);
        $loop = 0;
        while ($loop < 5){
            $resp = $this->countData($resp[1]);
            $s = array_merge($s, $resp[0]);
            $loop++;
        }


        return response()->json($s);
    }

    function countData($nextID = 0){
        $base_url = 'https://hk4e-api-os.hoyoverse.com/event/gacha_info/api/getGachaLog?';
        $auth_key = 'GZsnNRF4Gwu6wjPiUjh9V1i6AWxN7LWf4TmqRHdC51b5lc1dR5K6EVE%2fcREd0N3M4jp3Bg53Centxmrfxz9%2bojaz%2fClsGgXnp4Oy5V8t8HFwIE87DCsx1xy3IxuQb3LEvYYs6hfbPAFnXXV7GniFRMEgoPvDKlyCsAVzp666Oei3CBpIJjLRjbJcJcPWdk2o74kIZYv%2f39XXMm6XnwYBKxBK%2bsxyoFJLfvQ7ptNgUfZ7RXfIJUjX6J9V3JbsWQiQPBCis5347S4q7S2og8H0qQ6LGOvVdeDMtsPrf%2fy%2bDzFgubTLqXbXepPrUdzx3ZQOenGwwKJK601qDjrB4KoCWMkxouq4bHbrOp%2fqSSG%2f3zjTpBEt6j0a3kIhxwLFe22w7UUk%2bgRYUyejJIS2C6iRtHzUKS7%2fuAcdW3Ek6YPopGVdEaE3s5OvBe86fNh6g%2fGlnzF36Fo1c4uu%2bMV1iBTms04cbQOhu8OKrlpLCInuEF6QJyjl%2f1mWr3Yh02MQPMjnPTi7hp9unebLRF%2f%2fCu4RK96%2fve%2bkgz84atG047NOsy3WK%2bywEFAmh9WRtIJCIc68GvmJSdTqVyULUcXaOiF2sfVua518StOJGalemVuWZlZ2KFoYviULt%2ftquK%2b0JZrMP8dDohX7t9wvV4Dz2PWF5BV%2bj0Bm5AOylTp4skJnwSofC40FRf7Z4hiJUI6hMXeVdop%2fIekkFGgWokkCfxxu38di%2fn7Bm9ODhiESJk38Acq4iyjQ%2bZP%2f1Li3q2bjdauUAOIydbwbWdRW%2fbVuUOpxiWv2gQyC0ouZgpRGIgF5cDf7oOpYTTKyDrcNLm0a9APWGlkto2Gxm7v5IZjkbjbtVUDYH6LxFjF7IEgkCc48GSVa%2f4%2bGjCa8zywdkvGjOkq1FLJtSonczKBqcPkZKOdfhMDN4ZJYI9YRm1UVurilFyLzYZbsld70rCl0KZevbmIwHOpcooVmKBnFI%2f46j%2fS9JNq5bvVcu2cIVo%2bK7EJ%2fIB%2bXMiapKvB8IMwgjAXKWMbXzL%2fDwBf3wP319Ur%2b1vmP3YIWzjQ95EGMQ5XZlOtuMH5eGknHtfHIUBs2yQk9yFBkUoaNJVvFSjOnmMPLlDjqZDAf26MA96mHXLyiWnRDZazGo%2bA3KqONXvJ3f%2fu5QNIa%2fvNuppRnjygYZBkP42gPnoX1VERnX%2fETgCKhtpCggN%2bDHvqh2Vpdyt8FOB0T9y46np95IezDr6iT3J7WHN4ox45giPhZ18JUUTxnYBcCirDkJt4OLgQbNrabi1ElxojypxpJk%2bIdXZDzygye%2bTOjwaCJco%2fUG7zhXaFsO%2fIKSLZAzu%2f6FBCg4w%2fxniK%2bgNz3IHfCebXNYe7wCfGehPUPyg%3d%3d';

        $finUrl = $base_url.'authkey_ver=1&size=5&lang=id&gacha_type=301&end_id='.$nextID.'&authkey='.$auth_key;
        $client = new Client();
        $response = $client->request('GET', $finUrl);

        $raw = json_decode($response->getBody());
        $list = $raw->data->list;
        $length = count($raw->data->list);

        if ($length != 0){
            foreach ($list as $key => $item){
              if($key <= 4) {
                  $data[] = [
                      'id' => $item->id,
                      'time' => $item->time,
                      'name' => $item->name,
                      'type' => $item->item_type,
                      'rank' => $item->rank_type
                  ];
              }
              if($key == 4){
                  $nID = $item->id;
              }
            }
        }
        return array($data, $nID);
    }
}
