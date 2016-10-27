<?php


namespace app\lib\oAuth;
use app\lib\oAuth\SaeTOAuthV2;
use think\Model;


class SaeTClientV2
{
    
    function __construct( $akey, $skey, $access_token, $refresh_token = NULL)
    {
        $this->oauth = new SaeTOAuthV2( $akey, $skey, $access_token, $refresh_token );
    }

    
    function set_debug( $enable )
    {
        $this->oauth->debug = $enable;
    }

    
    function set_remote_ip( $ip )
    {
        if ( ip2long($ip) !== false ) {
            $this->oauth->remote_ip = $ip;
            return true;
        } else {
            return false;
        }
    }

    
    function public_timeline( $page = 1, $count = 50, $base_app = 0 )
    {
        $params = array();
        $params['count'] = intval($count);
        $params['page'] = intval($page);
        $params['base_app'] = intval($base_app);
        return $this->oauth->get('statuses/public_timeline', $params);//可能是接口的bug不能补全
    }

    
    function home_timeline( $page = 1, $count = 50, $since_id = 0, $max_id = 0, $base_app = 0, $feature = 0 )
    {
        $params = array();
        if ($since_id) {
            $this->id_format($since_id);
            $params['since_id'] = $since_id;
        }
        if ($max_id) {
            $this->id_format($max_id);
            $params['max_id'] = $max_id;
        }
        $params['count'] = intval($count);
        $params['page'] = intval($page);
        $params['base_app'] = intval($base_app);
        $params['feature'] = intval($feature);

        return $this->oauth->get('statuses/home_timeline', $params);
    }

    
    function friends_timeline( $page = 1, $count = 50, $since_id = 0, $max_id = 0, $base_app = 0, $feature = 0 )
    {
        return $this->home_timeline( $since_id, $max_id, $count, $page, $base_app, $feature);
    }

    
    function user_timeline_by_id( $uid = NULL , $page = 1 , $count = 50 , $since_id = 0, $max_id = 0, $feature = 0, $trim_user = 0, $base_app = 0)
    {
        $params = array();
        $params['uid']=$uid;
        if ($since_id) {
            $this->id_format($since_id);
            $params['since_id'] = $since_id;
        }
        if ($max_id) {
            $this->id_format($max_id);
            $params['max_id'] = $max_id;
        }
        $params['base_app'] = intval($base_app);
        $params['feature'] = intval($feature);
        $params['count'] = intval($count);
        $params['page'] = intval($page);
        $params['trim_user'] = intval($trim_user);

        return $this->oauth->get( 'statuses/user_timeline', $params );
    }


    
    function user_timeline_by_name( $screen_name = NULL , $page = 1 , $count = 50 , $since_id = 0, $max_id = 0, $feature = 0, $trim_user = 0, $base_app = 0 )
    {
        $params = array();
        $params['screen_name'] = $screen_name;
        if ($since_id) {
            $this->id_format($since_id);
            $params['since_id'] = $since_id;
        }
        if ($max_id) {
            $this->id_format($max_id);
            $params['max_id'] = $max_id;
        }
        $params['base_app'] = intval($base_app);
        $params['feature'] = intval($feature);
        $params['count'] = intval($count);
        $params['page'] = intval($page);
        $params['trim_user'] = intval($trim_user);

        return $this->oauth->get( 'statuses/user_timeline', $params );
    }



    
    function timeline_batch_by_name( $screen_name, $page = 1, $count = 50, $feature = 0, $base_app = 0)
    {
        $params = array();
        if (is_array($screen_name) && !empty($screen_name)) {
            $params['screen_name'] = join(',', $screen_name);
        } else {
            $params['screen_name'] = $screen_name;
        }
        $params['count'] = intval($count);
        $params['page'] = intval($page);
        $params['base_app'] = intval($base_app);
        $params['feature'] = intval($feature);
        return $this->oauth->get('statuses/timeline_batch', $params);
    }

    
    function timeline_batch_by_id( $uids, $page = 1, $count = 50, $feature = 0, $base_app = 0)
    {
        $params = array();
        if (is_array($uids) && !empty($uids)) {
            foreach($uids as $k => $v) {
                $this->id_format($uids[$k]);
            }
            $params['uids'] = join(',', $uids);
        } else {
            $params['uids'] = $uids;
        }
        $params['count'] = intval($count);
        $params['page'] = intval($page);
        $params['base_app'] = intval($base_app);
        $params['feature'] = intval($feature);
        return $this->oauth->get('statuses/timeline_batch', $params);
    }


    
    function repost_timeline( $sid, $page = 1, $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0 )
    {
        $this->id_format($sid);

        $params = array();
        $params['id'] = $sid;
        if ($since_id) {
            $this->id_format($since_id);
            $params['since_id'] = $since_id;
        }
        if ($max_id) {
            $this->id_format($max_id);
            $params['max_id'] = $max_id;
        }
        $params['filter_by_author'] = intval($filter_by_author);

        return $this->request_with_pager( 'statuses/repost_timeline', $page, $count, $params );
    }

    
    function repost_by_me( $page = 1, $count = 50, $since_id = 0, $max_id = 0 )
    {
        $params = array();
        if ($since_id) {
            $this->id_format($since_id);
            $params['since_id'] = $since_id;
        }
        if ($max_id) {
            $this->id_format($max_id);
            $params['max_id'] = $max_id;
        }

        return $this->request_with_pager('statuses/repost_by_me', $page, $count, $params );
    }

    
    function mentions( $page = 1, $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0, $filter_by_source = 0, $filter_by_type = 0 )
    {
        $params = array();
        if ($since_id) {
            $this->id_format($since_id);
            $params['since_id'] = $since_id;
        }
        if ($max_id) {
            $this->id_format($max_id);
            $params['max_id'] = $max_id;
        }
        $params['filter_by_author'] = $filter_by_author;
        $params['filter_by_source'] = $filter_by_source;
        $params['filter_by_type'] = $filter_by_type;

        return $this->request_with_pager( 'statuses/mentions', $page, $count, $params );
    }


    
    function show_status( $id )
    {
        $this->id_format($id);
        $params = array();
        $params['id'] = $id;
        return $this->oauth->get('statuses/show', $params);
    }

    
    function show_batch( $ids )
    {
        $params=array();
        if (is_array($ids) && !empty($ids)) {
            foreach($ids as $k => $v) {
                $this->id_format($ids[$k]);
            }
            $params['ids'] = join(',', $ids);
        } else {
            $params['ids'] = $ids;
        }
        return $this->oauth->get('statuses/show_batch', $params);
    }

    
    function querymid( $id, $type = 1, $is_batch = 0 )
    {
        $params = array();
        $params['id'] = $id;
        $params['type'] = intval($type);
        $params['is_batch'] = intval($is_batch);
        return $this->oauth->get( 'statuses/querymid',  $params);
    }

    
    function queryid( $mid, $type = 1, $is_batch = 0, $inbox = 0, $isBase62 = 0)
    {
        $params = array();
        $params['mid'] = $mid;
        $params['type'] = intval($type);
        $params['is_batch'] = intval($is_batch);
        $params['inbox'] = intval($inbox);
        $params['isBase62'] = intval($isBase62);
        return $this->oauth->get('statuses/queryid', $params);
    }

    
    function repost_daily( $count = 20, $base_app = 0)
    {
        $params = array();
        $params['count'] = intval($count);
        $params['base_app'] = intval($base_app);
        return $this->oauth->get('statuses/hot/repost_daily',  $params);
    }

    
    function repost_weekly( $count = 20,  $base_app = 0)
    {
        $params = array();
        $params['count'] = intval($count);
        $params['base_app'] = intval($base_app);
        return $this->oauth->get( 'statuses/hot/repost_weekly',  $params);
    }

    
    function comments_daily( $count = 20,  $base_app = 0)
    {
        $params =  array();
        $params['count'] = intval($count);
        $params['base_app'] = intval($base_app);
        return $this->oauth->get( 'statuses/hot/comments_daily',  $params);
    }

    
    function comments_weekly( $count = 20, $base_app = 0)
    {
        $params =  array();
        $params['count'] = intval($count);
        $params['base_app'] = intval($base_app);
        return $this->oauth->get( 'statuses/hot/comments_weekly', $params);
    }


    
    function repost( $sid, $text = NULL, $is_comment = 0 )
    {
        $this->id_format($sid);

        $params = array();
        $params['id'] = $sid;
        $params['is_comment'] = $is_comment;
        if( $text ) $params['status'] = $text;

        return $this->oauth->post( 'statuses/repost', $params  );
    }

    
    function delete( $id )
    {
        return $this->destroy( $id );
    }

    
    function destroy( $id )
    {
        $this->id_format($id);
        $params = array();
        $params['id'] = $id;
        return $this->oauth->post( 'statuses/destroy',  $params );
    }


    
    function update( $status, $lat = NULL, $long = NULL, $annotations = NULL )
    {
        $params = array();
        $params['status'] = $status;
        if ($lat) {
            $params['lat'] = floatval($lat);
        }
        if ($long) {
            $params['long'] = floatval($long);
        }
        if (is_string($annotations)) {
            $params['annotations'] = $annotations;
        } elseif (is_array($annotations)) {
            $params['annotations'] = json_encode($annotations);
        }

        return $this->oauth->post( 'statuses/update', $params );
    }

    
    function upload( $status, $pic_path, $lat = NULL, $long = NULL )
    {
        $params = array();
        $params['status'] = $status;
        $params['pic'] = '@'.$pic_path;
        if ($lat) {
            $params['lat'] = floatval($lat);
        }
        if ($long) {
            $params['long'] = floatval($long);
        }

        return $this->oauth->post( 'statuses/upload', $params, true );
    }


    
    function upload_url_text( $status,  $url , $visible=0, $list_id=NULL, $pic_id=NULL, $lat = NULL, $long=NULL, $annotations=NULL)
    {
        $params = array();
        $params['status'] = $status;
        $params['url'] = $url;
        $params['visible'] = $visible;
        if (!is_null($list_id)) {
            $params['list_id'] = $list_id;
        }
        if (!is_null($pic_id)) {
            $params['pic_id'] = $pic_id;
        }
        if (!is_null($lat)) {
            $params['lat'] = $lat;
        }
        if (!is_null($long)) {
            $params['long'] = $long;
        }
        if (!is_null($annotations)) {
            $params['annotations'] = $annotations;
        }
        return $this->oauth->post( 'statuses/upload_url_text', $params, true );
    }


    
    function emotions( $type = "face", $language = "cnname" )
    {
        $params = array();
        $params['type'] = $type;
        $params['language'] = $language;
        return $this->oauth->get( 'emotions', $params );
    }


    
    function get_comments_by_sid( $sid, $page = 1, $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0 )
    {
        $params = array();
        $this->id_format($sid);
        $params['id'] = $sid;
        if ($since_id) {
            $this->id_format($since_id);
            $params['since_id'] = $since_id;
        }
        if ($max_id) {
            $this->id_format($max_id);
            $params['max_id'] = $max_id;
        }
        $params['count'] = $count;
        $params['page'] = $page;
        $params['filter_by_author'] = $filter_by_author;
        return $this->oauth->get( 'comments/show',  $params );
    }


    
    function comments_by_me( $page = 1 , $count = 50, $since_id = 0, $max_id = 0,  $filter_by_source = 0 )
    {
        $params = array();
        if ($since_id) {
            $this->id_format($since_id);
            $params['since_id'] = $since_id;
        }
        if ($max_id) {
            $this->id_format($max_id);
            $params['max_id'] = $max_id;
        }
        $params['count'] = $count;
        $params['page'] = $page;
        $params['filter_by_source'] = $filter_by_source;
        return $this->oauth->get( 'comments/by_me', $params );
    }

    
    function comments_to_me( $page = 1 , $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0, $filter_by_source = 0)
    {
        $params = array();
        if ($since_id) {
            $this->id_format($since_id);
            $params['since_id'] = $since_id;
        }
        if ($max_id) {
            $this->id_format($max_id);
            $params['max_id'] = $max_id;
        }
        $params['count'] = $count;
        $params['page'] = $page;
        $params['filter_by_author'] = $filter_by_author;
        $params['filter_by_source'] = $filter_by_source;
        return $this->oauth->get( 'comments/to_me', $params );
    }

    
    function comments_timeline( $page = 1, $count = 50, $since_id = 0, $max_id = 0 )
    {
        $params = array();
        if ($since_id) {
            $this->id_format($since_id);
            $params['since_id'] = $since_id;
        }
        if ($max_id) {
            $this->id_format($max_id);
            $params['max_id'] = $max_id;
        }

        return $this->request_with_pager( 'comments/timeline', $page, $count, $params );
    }


    
    function comments_mentions( $page = 1, $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0, $filter_by_source = 0)
    {
        $params = array();
        $params['since_id'] = $since_id;
        $params['max_id'] = $max_id;
        $params['count'] = $count;
        $params['page'] = $page;
        $params['filter_by_author'] = $filter_by_author;
        $params['filter_by_source'] = $filter_by_source;
        return $this->oauth->get( 'comments/mentions', $params );
    }


    
    function comments_show_batch( $cids )
    {
        $params = array();
        if (is_array( $cids) && !empty( $cids)) {
            foreach($cids as $k => $v) {
                $this->id_format($cids[$k]);
            }
            $params['cids'] = join(',', $cids);
        } else {
            $params['cids'] = $cids;
        }
        return $this->oauth->get( 'comments/show_batch', $params );
    }


    
    function send_comment( $id , $comment , $comment_ori = 0)
    {
        $params = array();
        $params['comment'] = $comment;
        $this->id_format($id);
        $params['id'] = $id;
        $params['comment_ori'] = $comment_ori;
        return $this->oauth->post( 'comments/create', $params );
    }

    
    function comment_destroy( $cid )
    {
        $params = array();
        $params['cid'] = $cid;
        return $this->oauth->post( 'comments/destroy', $params);
    }


    
    function comment_destroy_batch( $ids )
    {
        $params = array();
        if (is_array($ids) && !empty($ids)) {
            foreach($ids as $k => $v) {
                $this->id_format($ids[$k]);
            }
            $params['cids'] = join(',', $ids);
        } else {
            $params['cids'] = $ids;
        }
        return $this->oauth->post( 'comments/destroy_batch', $params);
    }


    
    function reply( $sid, $text, $cid, $without_mention = 0, $comment_ori = 0 )
    {
        $this->id_format( $sid );
        $this->id_format( $cid );
        $params = array();
        $params['id'] = $sid;
        $params['comment'] = $text;
        $params['cid'] = $cid;
        $params['without_mention'] = $without_mention;
        $params['comment_ori'] = $comment_ori;

        return $this->oauth->post( 'comments/reply', $params );

    }

    
    function show_user_by_id( $uid )
    {
        $params=array();
        if ( $uid !== NULL ) {
            $this->id_format($uid);
            $params['uid'] = $uid;
        }

        return $this->oauth->get('users/show', $params );
    }

    
    function show_user_by_name( $screen_name )
    {
        $params = array();
        $params['screen_name'] = $screen_name;

        return $this->oauth->get( 'users/show', $params );
    }

    
    function domain_show( $domain )
    {
        $params = array();
        $params['domain'] = $domain;
        return $this->oauth->get( 'users/domain_show', $params );
    }

    
    function users_show_batch_by_id( $uids )
    {
        $params = array();
        if (is_array( $uids ) && !empty( $uids )) {
            foreach( $uids as $k => $v ) {
                $this->id_format( $uids[$k] );
            }
            $params['uids'] = join(',', $uids);
        } else {
            $params['uids'] = $uids;
        }
        return $this->oauth->get( 'users/show_batch', $params );
    }

    
    function users_show_batch_by_name( $screen_name )
    {
        $params = array();
        if (is_array( $screen_name ) && !empty( $screen_name )) {
            $params['screen_name'] = join(',', $screen_name);
        } else {
            $params['screen_name'] = $screen_name;
        }
        return $this->oauth->get( 'users/show_batch', $params );
    }


    
    function friends_by_id( $uid, $cursor = 0, $count = 50 )
    {
        $params = array();
        $params['cursor'] = $cursor;
        $params['count'] = $count;
        $params['uid'] = $uid;

        return $this->oauth->get( 'friendships/friends', $params );
    }


    
    function friends_by_name( $screen_name, $cursor = 0, $count = 50 )
    {
        $params = array();
        $params['cursor'] = $cursor;
        $params['count'] = $count;
        $params['screen_name'] = $screen_name;
        return $this->oauth->get( 'friendships/friends', $params );
    }


    
    function friends_in_common( $uid, $suid = NULL, $page = 1, $count = 50 )
    {
        $params = array();
        $params['uid'] = $uid;
        $params['suid'] = $suid;
        $params['count'] = $count;
        $params['page'] = $page;
        return $this->oauth->get( 'friendships/friends/in_common', $params  );
    }

    
    function bilateral( $uid, $page = 1, $count = 50, $sort = 0 )
    {
        $params = array();
        $params['uid'] = $uid;
        $params['count'] = $count;
        $params['page'] = $page;
        $params['sort'] = $sort;
        return $this->oauth->get( 'friendships/friends/bilateral', $params  );
    }

    
    function bilateral_ids( $uid, $page = 1, $count = 50, $sort = 0)
    {
        $params = array();
        $params['uid'] = $uid;
        $params['count'] = $count;
        $params['page'] = $page;
        $params['sort'] = $sort;
        return $this->oauth->get( 'friendships/friends/bilateral/ids',  $params  );
    }

    
    function friends_ids_by_id( $uid, $cursor = 0, $count = 500 )
    {
        $params = array();
        $this->id_format($uid);
        $params['uid'] = $uid;
        $params['cursor'] = $cursor;
        $params['count'] = $count;
        return $this->oauth->get( 'friendships/friends/ids', $params );
    }

    
    function friends_ids_by_name( $screen_name, $cursor = 0, $count = 500 )
    {
        $params = array();
        $params['cursor'] = $cursor;
        $params['count'] = $count;
        $params['screen_name'] = $screen_name;
        return $this->oauth->get( 'friendships/friends/ids', $params );
    }


    
    function friends_remark_batch( $uids )
    {
        $params = array();
        if (is_array( $uids ) && !empty( $uids )) {
            foreach( $uids as $k => $v) {
                $this->id_format( $uids[$k] );
            }
            $params['uids'] = join(',', $uids);
        } else {
            $params['uids'] = $uids;
        }
        return $this->oauth->get( 'friendships/friends/remark_batch', $params  );
    }

    
    function followers_by_id( $uid , $cursor = 0 , $count = 50)
    {
        $params = array();
        $this->id_format($uid);
        $params['uid'] = $uid;
        $params['count'] = $count;
        $params['cursor'] = $cursor;
        return $this->oauth->get( 'friendships/followers', $params  );
    }

    
    function followers_by_name( $screen_name, $cursor = 0 , $count = 50 )
    {
        $params = array();
        $params['screen_name'] = $screen_name;
        $params['count'] = $count;
        $params['cursor'] = $cursor;
        return $this->oauth->get( 'friendships/followers', $params  );
    }

    
    function followers_ids_by_id( $uid, $cursor = 0 , $count = 50 )
    {
        $params = array();
        $this->id_format($uid);
        $params['uid'] = $uid;
        $params['count'] = $count;
        $params['cursor'] = $cursor;
        return $this->oauth->get( 'friendships/followers/ids', $params  );
    }

    
    function followers_ids_by_name( $screen_name, $cursor = 0 , $count = 50 )
    {
        $params = array();
        $params['screen_name'] = $screen_name;
        $params['count'] = $count;
        $params['cursor'] = $cursor;
        return $this->oauth->get( 'friendships/followers/ids', $params  );
    }

    
    function followers_active( $uid,  $count = 20)
    {
        $param = array();
        $this->id_format($uid);
        $param['uid'] = $uid;
        $param['count'] = $count;
        return $this->oauth->get( 'friendships/followers/active', $param);
    }


    
    function friends_chain_followers( $uid, $page = 1, $count = 50 )
    {
        $params = array();
        $this->id_format($uid);
        $params['uid'] = $uid;
        $params['count'] = $count;
        $params['page'] = $page;
        return $this->oauth->get( 'friendships/friends_chain/followers',  $params );
    }

    
    function is_followed_by_id( $target_id, $source_id = NULL )
    {
        $params = array();
        $this->id_format($target_id);
        $params['target_id'] = $target_id;

        if ( $source_id != NULL ) {
            $this->id_format($source_id);
            $params['source_id'] = $source_id;
        }

        return $this->oauth->get( 'friendships/show', $params );
    }

    
    function is_followed_by_name( $target_name, $source_name = NULL )
    {
        $params = array();
        $params['target_screen_name'] = $target_name;

        if ( $source_name != NULL ) {
            $params['source_screen_name'] = $source_name;
        }

        return $this->oauth->get( 'friendships/show', $params );
    }

    
    function follow_by_id( $uid )
    {
        $params = array();
        $this->id_format($uid);
        $params['uid'] = $uid;
        return $this->oauth->post( 'friendships/create', $params );
    }

    
    function follow_by_name( $screen_name )
    {
        $params = array();
        $params['screen_name'] = $screen_name;
        return $this->oauth->post( 'friendships/create', $params);
    }


    
    function follow_create_batch( $uids )
    {
        $params = array();
        if (is_array($uids) && !empty($uids)) {
            foreach($uids as $k => $v) {
                $this->id_format($uids[$k]);
            }
            $params['uids'] = join(',', $uids);
        } else {
            $params['uids'] = $uids;
        }
        return $this->oauth->post( 'friendships/create_batch', $params);
    }

    
    function unfollow_by_id( $uid )
    {
        $params = array();
        $this->id_format($uid);
        $params['uid'] = $uid;
        return $this->oauth->post( 'friendships/destroy', $params);
    }

    
    function unfollow_by_name( $screen_name )
    {
        $params = array();
        $params['screen_name'] = $screen_name;
        return $this->oauth->post( 'friendships/destroy', $params);
    }

    
    function update_remark( $uid, $remark )
    {
        $params = array();
        $this->id_format($uid);
        $params['uid'] = $uid;
        $params['remark'] = $remark;
        return $this->oauth->post( 'friendships/remark/update', $params);
    }

    
    function list_dm( $page = 1, $count = 50, $since_id = 0, $max_id = 0 )
    {
        $params = array();
        if ($since_id) {
            $this->id_format($since_id);
            $params['since_id'] = $since_id;
        }
        if ($max_id) {
            $this->id_format($max_id);
            $params['max_id'] = $max_id;
        }

        return $this->request_with_pager( 'direct_messages', $page, $count, $params );
    }

    
    function list_dm_sent( $page = 1, $count = 50, $since_id = 0, $max_id = 0 )
    {
        $params = array();
        if ($since_id) {
            $this->id_format($since_id);
            $params['since_id'] = $since_id;
        }
        if ($max_id) {
            $this->id_format($max_id);
            $params['max_id'] = $max_id;
        }

        return $this->request_with_pager( 'direct_messages/sent', $page, $count, $params );
    }


    
    function dm_user_list( $count = 20, $cursor = 0)
    {
        $params = array();
        $params['count'] = $count;
        $params['cursor'] = $cursor;
        return $this->oauth->get( 'direct_messages/user_list', $params );
    }

    
    function dm_conversation( $uid, $page = 1, $count = 50, $since_id = 0, $max_id = 0)
    {
        $params = array();
        $this->id_format($uid);
        $params['uid'] = $uid;
        if ($since_id) {
            $this->id_format($since_id);
            $params['since_id'] = $since_id;
        }
        if ($max_id) {
            $this->id_format($max_id);
            $params['max_id'] = $max_id;
        }
        $params['count'] = $count;
        $params['page'] = $page;
        return $this->oauth->get( 'direct_messages/conversation', $params );
    }

    
    function dm_show_batch( $dmids )
    {
        $params = array();
        if (is_array($dmids) && !empty($dmids)) {
            foreach($dmids as $k => $v) {
                $this->id_format($dmids[$k]);
            }
            $params['dmids'] = join(',', $dmids);
        } else {
            $params['dmids'] = $dmids;
        }
        return $this->oauth->get( 'direct_messages/show_batch',  $params );
    }

    
    function send_dm_by_id( $uid, $text, $id = NULL )
    {
        $params = array();
        $this->id_format( $uid );
        $params['text'] = $text;
        $params['uid'] = $uid;
        if ($id) {
            $this->id_format( $id );
            $params['id'] = $id;
        }
        return $this->oauth->post( 'direct_messages/new', $params );
    }

    
    function send_dm_by_name( $screen_name, $text, $id = NULL )
    {
        $params = array();
        $params['text'] = $text;
        $params['screen_name'] = $screen_name;
        if ($id) {
            $this->id_format( $id );
            $params['id'] = $id;
        }
        return $this->oauth->post( 'direct_messages/new', $params);
    }

    
    function delete_dm( $did )
    {
        $this->id_format($did);
        $params = array();
        $params['id'] = $did;
        return $this->oauth->post('direct_messages/destroy', $params);
    }

    
    function delete_dms( $dids )
    {
        $params = array();
        if (is_array($dids) && !empty($dids)) {
            foreach($dids as $k => $v) {
                $this->id_format($dids[$k]);
            }
            $params['ids'] = join(',', $dids);
        } else {
            $params['ids'] = $dids;
        }

        return $this->oauth->post( 'direct_messages/destroy_batch', $params);
    }



    
    function account_profile_basic( $uid = NULL  )
    {
        $params = array();
        if ($uid) {
            $this->id_format($uid);
            $params['uid'] = $uid;
        }
        return $this->oauth->get( 'account/profile/basic', $params );
    }

    
    function account_education( $uid = NULL )
    {
        $params = array();
        if ($uid) {
            $this->id_format($uid);
            $params['uid'] = $uid;
        }
        return $this->oauth->get( 'account/profile/education', $params );
    }

    
    function account_education_batch( $uids  )
    {
        $params = array();
        if (is_array($uids) && !empty($uids)) {
            foreach($uids as $k => $v) {
                $this->id_format($uids[$k]);
            }
            $params['uids'] = join(',', $uids);
        } else {
            $params['uids'] = $uids;
        }

        return $this->oauth->get( 'account/profile/education_batch', $params );
    }


    
    function account_career( $uid = NULL )
    {
        $params = array();
        if ($uid) {
            $this->id_format($uid);
            $params['uid'] = $uid;
        }
        return $this->oauth->get( 'account/profile/career', $params );
    }

    
    function account_career_batch( $uids )
    {
        $params = array();
        if (is_array($uids) && !empty($uids)) {
            foreach($uids as $k => $v) {
                $this->id_format($uids[$k]);
            }
            $params['uids'] = join(',', $uids);
        } else {
            $params['uids'] = $uids;
        }

        return $this->oauth->get( 'account/profile/career_batch', $params );
    }

    
    function get_privacy()
    {
        return $this->oauth->get('account/get_privacy');
    }

    
    function school_list( $query )
    {
        $params = $query;

        return $this->oauth->get( 'account/profile/school_list', $params );
    }

    
    function rate_limit_status()
    {
        return $this->oauth->get( 'account/rate_limit_status' );
    }

    
    function get_uid()
    {
        return $this->oauth->get( 'account/get_uid' );
    }


    
    function update_profile( $profile )
    {
        return $this->oauth->post( 'account/profile/basic_update',  $profile);
    }


    
    function edu_update( $edu_update )
    {
        return $this->oauth->post( 'account/profile/edu_update',  $edu_update);
    }

    
    function edu_destroy( $id )
    {
        $this->id_format( $id );
        $params = array();
        $params['id'] = $id;
        return $this->oauth->post( 'account/profile/edu_destroy', $params);
    }

    
    function car_update( $car_update )
    {
        return $this->oauth->post( 'account/profile/car_update', $car_update);
    }

    
    function car_destroy( $id )
    {
        $this->id_format($id);
        $params = array();
        $params['id'] = $id;
        return $this->oauth->post( 'account/profile/car_destroy', $params);
    }

    
    function update_profile_image( $image_path )
    {
        $params = array();
        $params['image'] = "@{$image_path}";

        return $this->oauth->post('account/avatar/upload', $params, true);
    }

    
    function update_privacy( $privacy_settings )
    {
        return $this->oauth->post( 'account/update_privacy', $privacy_settings);
    }


    
    function get_favorites( $page = 1, $count = 50 )
    {
        $params = array();
        $params['page'] = intval($page);
        $params['count'] = intval($count);

        return $this->oauth->get( 'favorites', $params );
    }


    
    function favorites_show( $id )
    {
        $params = array();
        $this->id_format($id);
        $params['id'] = $id;
        return $this->oauth->get( 'favorites/show', $params );
    }


    
    function favorites_by_tags( $tid, $page = 1, $count = 50)
    {
        $params = array();
        $params['tid'] = $tid;
        $params['count'] = $count;
        $params['page'] = $page;
        return $this->oauth->get( 'favorites/by_tags', $params );
    }


    
    function favorites_tags( $page = 1, $count = 50)
    {
        $params = array();
        $params['count'] = $count;
        $params['page'] = $page;
        return $this->oauth->get( 'favorites/tags', $params );
    }


    
    function add_to_favorites( $sid )
    {
        $this->id_format($sid);
        $params = array();
        $params['id'] = $sid;

        return $this->oauth->post( 'favorites/create', $params );
    }

    
    function remove_from_favorites( $id )
    {
        $this->id_format($id);
        $params = array();
        $params['id'] = $id;
        return $this->oauth->post( 'favorites/destroy', $params);
    }


    
    function remove_from_favorites_batch( $fids )
    {
        $params = array();
        if (is_array($fids) && !empty($fids)) {
            foreach ($fids as $k => $v) {
                $this->id_format($fids[$k]);
            }
            $params['ids'] = join(',', $fids);
        } else {
            $params['ids'] = $fids;
        }

        return $this->oauth->post( 'favorites/destroy_batch', $params);
    }


    
    function favorites_tags_update( $id,  $tags )
    {
        $params = array();
        $params['id'] = $id;
        if (is_array($tags) && !empty($tags)) {
            foreach ($tags as $k => $v) {
                $this->id_format($tags[$k]);
            }
            $params['tags'] = join(',', $tags);
        } else {
            $params['tags'] = $tags;
        }
        return $this->oauth->post( 'favorites/tags/update', $params );
    }

    
    function favorites_update_batch( $tid, $tag )
    {
        $params = array();
        $params['tid'] = $tid;
        $params['tag'] = $tag;
        return $this->oauth->post( 'favorites/tags/update_batch', $params);
    }

    
    function favorites_tags_destroy_batch( $tid )
    {
        $params = array();
        $params['tid'] = $tid;
        return $this->oauth->post( 'favorites/tags/destroy_batch', $params);
    }

    
    function get_trends( $uid = NULL, $page = 1, $count = 10 )
    {
        $params = array();
        if ($uid) {
            $params['uid'] = $uid;
        } else {
            $user_info = $this->get_uid();
            $params['uid'] = $user_info['uid'];
        }
        $this->id_format( $params['uid'] );
        $params['page'] = $page;
        $params['count'] = $count;
        return $this->oauth->get( 'trends', $params );
    }


    
    function trends_is_follow( $trend_name )
    {
        $params = array();
        $params['trend_name'] = $trend_name;
        return $this->oauth->get( 'trends/is_follow', $params );
    }

    
    function hourly_trends( $base_app = 0 )
    {
        $params = array();
        $params['base_app'] = $base_app;

        return $this->oauth->get( 'trends/hourly', $params );
    }

    
    function daily_trends( $base_app = 0 )
    {
        $params = array();
        $params['base_app'] = $base_app;

        return $this->oauth->get( 'trends/daily', $params );
    }

    
    function weekly_trends( $base_app = 0 )
    {
        $params = array();
        $params['base_app'] = $base_app;

        return $this->oauth->get( 'trends/weekly', $params );
    }

    
    function follow_trends( $trend_name )
    {
        $params = array();
        $params['trend_name'] = $trend_name;
        return $this->oauth->post( 'trends/follow', $params );
    }

    
    function unfollow_trends( $tid )
    {
        $this->id_format($tid);

        $params = array();
        $params['trend_id'] = $tid;

        return $this->oauth->post( 'trends/destroy', $params );
    }

    
    function get_tags( $uid = NULL, $page = 1, $count = 20 )
    {
        $params = array();
        if ( $uid ) {
            $params['uid'] = $uid;
        } else {
            $user_info = $this->get_uid();
            $params['uid'] = $user_info['uid'];
        }
        $this->id_format( $params['uid'] );
        $params['page'] = $page;
        $params['count'] = $count;
        return $this->oauth->get( 'tags', $params );
    }

    
    function get_tags_batch( $uids )
    {
        $params = array();
        if (is_array( $uids ) && !empty( $uids )) {
            foreach ($uids as $k => $v) {
                $this->id_format( $uids[$k] );
            }
            $params['uids'] = join(',', $uids);
        } else {
            $params['uids'] = $uids;
        }
        return $this->oauth->get( 'tags/tags_batch', $params );
    }

    
    function get_suggest_tags( $count = 10)
    {
        $params = array();
        $params['count'] = intval($count);
        return $this->oauth->get( 'tags/suggestions', $params );
    }

    
    function add_tags( $tags )
    {
        $params = array();
        if (is_array($tags) && !empty($tags)) {
            $params['tags'] = join(',', $tags);
        } else {
            $params['tags'] = $tags;
        }
        return $this->oauth->post( 'tags/create', $params);
    }

    
    function delete_tag( $tag_id )
    {
        $params = array();
        $params['tag_id'] = $tag_id;
        return $this->oauth->post( 'tags/destroy', $params );
    }

    
    function delete_tags( $ids )
    {
        $params = array();
        if (is_array($ids) && !empty($ids)) {
            $params['ids'] = join(',', $ids);
        } else {
            $params['ids'] = $ids;
        }
        return $this->oauth->post( 'tags/destroy_batch', $params );
    }


    
    function verify_nickname( $nickname )
    {
        $params = array();
        $params['nickname'] = $nickname;
        return $this->oauth->get( 'register/verify_nickname', $params );
    }



    
    function search_users( $q,  $count = 10 )
    {
        $params = array();
        $params['q'] = $q;
        $params['count'] = $count;
        return $this->oauth->get( 'search/suggestions/users',  $params );
    }


    
    function search_statuses( $q,  $count = 10)
    {
        $params = array();
        $params['q'] = $q;
        $params['count'] = $count;
        return $this->oauth->get( 'search/suggestions/statuses', $params );
    }


    
    function search_schools( $q,  $count = 10,  $type = 1)
    {
        $params = array();
        $params['q'] = $q;
        $params['count'] = $count;
        $params['type'] = $type;
        return $this->oauth->get( 'search/suggestions/schools', $params );
    }

    
    function search_companies( $q, $count = 10)
    {
        $params = array();
        $params['q'] = $q;
        $params['count'] = $count;
        return $this->oauth->get( 'search/suggestions/companies', $params );
    }


    
    function search_at_users( $q, $count = 10, $type=0, $range = 2)
    {
        $params = array();
        $params['q'] = $q;
        $params['count'] = $count;
        $params['type'] = $type;
        $params['range'] = $range;
        return $this->oauth->get( 'search/suggestions/at_users', $params );
    }





    
    function search_statuses_high( $query )
    {
        return $this->oauth->get( 'search/statuses', $query );
    }



    
    function search_users_keywords( $query )
    {
        return $this->oauth->get( 'search/users', $query );
    }



    
    function hot_users( $category = "default" )
    {
        $params = array();
        $params['category'] = $category;

        return $this->oauth->get( 'suggestions/users/hot', $params );
    }

    
    function suggestions_may_interested( $page = 1, $count = 10 )
    {
        $params = array();
        $params['page'] = $page;
        $params['count'] = $count;
        return $this->oauth->get( 'suggestions/users/may_interested', $params);
    }

    
    function suggestions_users_by_status( $content, $num = 10 )
    {
        $params = array();
        $params['content'] = $content;
        $params['num'] = $num;
        return $this->oauth->get( 'suggestions/users/by_status', $params);
    }

    
    function hot_favorites( $page = 1, $count = 20 )
    {
        $params = array();
        $params['count'] = $count;
        $params['page'] = $page;
        return $this->oauth->get( 'suggestions/favorites/hot', $params);
    }

    
    function put_users_not_interested( $uid )
    {
        $params = array();
        $params['uid'] = $uid;
        return $this->oauth->post( 'suggestions/users/not_interested', $params);
    }



    // =========================================

    
    protected function request_with_pager( $url, $page = false, $count = false, $params = array() )
    {
        if( $page ) $params['page'] = $page;
        if( $count ) $params['count'] = $count;

        return $this->oauth->get($url, $params );
    }

    
    protected function request_with_uid( $url, $uid_or_name, $page = false, $count = false, $cursor = false, $post = false, $params = array())
    {
        if( $page ) $params['page'] = $page;
        if( $count ) $params['count'] = $count;
        if( $cursor )$params['cursor'] =  $cursor;

        if( $post ) $method = 'post';
        else $method = 'get';

        if ( $uid_or_name !== NULL ) {
            $this->id_format($uid_or_name);
            $params['id'] = $uid_or_name;
        }

        return $this->oauth->$method($url, $params );

    }

    
    protected function id_format(&$id) {
        if ( is_float($id) ) {
            $id = number_format($id, 0, '', '');
        } elseif ( is_string($id) ) {
            $id = trim($id);
        }
    }

}