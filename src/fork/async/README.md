### Async Connection And Execute

build: Windows 10, PHP 7.4.\*, Apache 2.4.\*, Opcache, Ryzen 7 2700 Super, DDR4-3000, HDD/150mbs

minimum connection time: ~ 0.0006 sec.
<br>
maximum connection time: ~ 0.012 sec.

### Example Async Connection

<pre>
use Stafred\Async\Client\Connect as AsyncConnect;
use Stafred\Async\Client\Message as AsyncMessage;
use Stafred\Async\Client\Pack as AsyncPack;

class ... {

    public function ... {
    
        $async = new AsyncConnect();
        
        $async->event(new class extends AsyncMessage {
        
            public function create(): AsyncPack
            {
                return (new AsyncPack())
                    ->wrap('','','','','')
                    ->wrap('','','','','')
                    ->wrap('','','','','');
            }
            
        });
        
        $async->run();
        
    }
}
</pre>
##### connect to server for asynchronous execution
<pre>
$async = new AsyncConnect();
</pre>
##### triggering an asynchronous execution event
##### adding message on asynchronous job
<pre>
$async->event(new class extends AsyncMessage {
</pre>
##### creation of message packaging with a single standard for an asynchronous server
<pre>
    public function create(): AsyncPack
    {
</pre>    
##### standardized message packaging
<pre>
        return (new AsyncPack())
            ->wrap('','','','','')
            ->wrap('','','','','')
            ->wrap('','','','','');
    }
});    
</pre>  
##### sending an asynchronous solution
<pre>
$async->run();   
</pre>  
