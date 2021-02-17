<?php

class My_REST_Posts_Controller
{
    public function __construct()
    {
        $this->REQUEST_KEY     = 'dqd94f3lyt0hp2g9doitvlpika4zj46w1fxsnnm08se9zncj';
        $this->ERROR_01 = '10001'; //WRONG KEY
        $this->ERROR_02 = '10002'; //MORE THAN 10 chapter for one book 
        $this->ERROR_03 = '10003'; //WRONG BOOK ID or CHAPTER ID
        $this->ERROR_04 = '10004'; //Request parameter include bookId and chapterId
        $this->ERROR_05 = '10005'; //Wrong bookId or chapterId
    }
    public function curl_request($postfields)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, 'https://api.deepl.com/v2/translate');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result =  curl_exec($ch);
        if ($result === false || $result == "") {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }
        curl_close($ch);
        return $result;
    }

    // Register our routes.
    public function register_routes()
    {

        register_rest_route('/hanzhiwen', '/getChapter', array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array($this, 'get_chapter'),
                'permission_callback' => array($this, 'permissions_check'),
            ),
            // Register our schema callback.
            'schema' => array($this, 'get_item_schema'),
        ));

     
        register_rest_route('/hanzhiwen', '/getContent', array(
            // Here we register the readable endpoint for collections.
            array(
                'methods'   => 'GET',
                'callback'  => array($this, 'get_content'),
                'permission_callback' => array($this, 'permissions_check'),
            ),
            // Register our schema callback.
            'schema' => array($this, 'get_item_schema'),
        ));
    }

    public function permissions_check($request)
    {
        if ($_GET['key'] != $this->REQUEST_KEY) {
            return new WP_Error('rest_forbidden', esc_html__('You key does not look right'), array('status' => $this->ERROR_01));
        }
        return true;
    }


    public function get_chapter($request)
    {
        // http://sinovelai.local/wp-json/hanzhiwen/getChapter?key=dqd94f3lyt0hp2g9doitvlpika4zj46w1fxsnnm08se9zncj&bookId=3051571
        $bookId = $_GET['bookId'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://openapi.yc.ifeng.com/open/getBookInfo/?cpid=hanzhiwen&bookId=' . $bookId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = array();

        $xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $data = json_decode($json, TRUE);

        return rest_ensure_response($data);
    }


    public function get_content($request)
    {
        // http://sinovelai.local/wp-json/hanzhiwen/getContent?key=dqd94f3lyt0hp2g9doitvlpika4zj46w1fxsnnm08se9zncj&bookId=3051571&chapterId=13758348


        $bookId = $_GET['bookId'];
        $chapterId = $_GET['chapterId'];
        $res = array();

        if (!$bookId || !$chapterId) {
            $res['code'] = "rest_forbidden";
            $res['message'] = "Request parameter include bookId and chapterId";
            $res['data'] = array('status' => $this->ERROR_04);
            return rest_ensure_response($res);
        }



        global $wpdb;
        $SQL_get_chapter_number = "select count(*) as cnum from wp_postmeta WHERE meta_key='book_id' and meta_value= '{$bookId}'";
        $chapter_number = $wpdb->get_results($SQL_get_chapter_number);

        $cnum = (int)($chapter_number[0]->cnum);
        //bail if this book's chapter number>10
        if ($cnum > 10) {
            $res['code'] = "rest_forbidden";
            $res['message'] = "You cannot view more than 10 chapters";
            $res['data'] = array('status' => $this->ERROR_02);
            return rest_ensure_response($res);
        }


        $res['bookId'] = $bookId;
        $res['chapterId'] = $chapterId;

        $store_chapter = get_page_by_title($bookId . ',' . $chapterId, OBJECT, 'post');

        if ($store_chapter) {
            $res['content'] = $store_chapter->post_content;
            return rest_ensure_response($res);
        } else {

            //Calculate SHA-1 Key
            $cpid="hanzhiwen";
            $idcode="b22c62d875cedc9ff380a0568190b49b";
            $seed= $cpid.$idcode.$bookId;
            $sha1_key=sha1($seed);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://openapi.yc.ifeng.com/open/getPartContent/?cpid=hanzhiwen&key='.$sha1_key.'&bookId=' . $bookId . '&chapterId=' . $chapterId,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);


            $data = array();
            $xml = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
            $json = json_encode($xml);
            $data = json_decode($json, TRUE);

            if (!$data['content']) {
                $res['code'] = "rest_forbidden";
                $res['message'] = "Wrong bookId or chapterId";
                $res['data'] = array('status' => $this->ERROR_05);
                return rest_ensure_response($res);
            }


            //网文常用字典替换
            $data['content'] = str_replace("大6", "大陆", $data['content']);
            $data['content'] = str_replace("艹", "操", $data['content']);


            $postfields = array(
                'auth_key' => 'b9cfd125-5af6-2ad7-ab60-22475d3f096f',
                'text' => $data['content'],
                'target_lang' => 'EN'
            );

            $result = $this->curl_request($postfields);
            $jsonobj = json_decode($result);


            $res['content'] = $jsonobj->translations[0]->text;


            // Gather post data.
            $my_post = array(
                'post_title'    => $bookId . ',' . $chapterId,
                'post_content'  => $jsonobj->translations[0]->text,
                'post_status'   => 'publish',
            );

            // Insert the post into the database.
            $new_post_id = wp_insert_post($my_post);

            update_post_meta($new_post_id, 'book_id', $bookId);

            return rest_ensure_response($res);
        }
    }


    /**
     * Get our sample schema for a post.
     *
     * @return array The sample schema for a post
     */
    public function get_item_schema()
    {
        if ($this->schema) {
            // Since WordPress 5.3, the schema can be cached in the $schema property.
            return $this->schema;
        }

        $this->schema = array(
            // This tells the spec of JSON Schema we are using which is draft 4.
            '$schema'              => 'http://json-schema.org/draft-04/schema#',
            // The title property marks the identity of the resource.
            'title'                => 'post',
            'type'                 => 'object',
            // In JSON Schema you can specify object properties in the properties attribute.
            'properties'           => array(
                'id' => array(
                    'description'  => esc_html__('Unique identifier for the object.', 'my-textdomain'),
                    'type'         => 'integer',
                    'context'      => array('view', 'edit', 'embed'),
                    'readonly'     => true,
                ),
                'content' => array(
                    'description'  => esc_html__('The content for the object.', 'my-textdomain'),
                    'type'         => 'string',
                ),
            ),
        );

        return $this->schema;
    }
}

// Function to register our new routes from the controller.
function prefix_register_my_rest_routes()
{
    $controller = new My_REST_Posts_Controller();
    $controller->register_routes();
}

add_action('rest_api_init', 'prefix_register_my_rest_routes');
