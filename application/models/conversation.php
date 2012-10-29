<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adi
 * Date: 10/25/12
 * Time: 12:23 AM
 * To change this template use File | Settings | File Templates.
 */
class Conversation extends Eloquent {

    public static $table = 'conversation';

    public function users() {
        return $this->has_many_and_belongs_to('User');
    }

    public function messages() {
        return $this->has_many('Message', 'topic_id');
    }

    public function markRead() {
        foreach($this->messages() as $m) {
            $m->read = true;
            $m->save();
        }
    }

    public static function listAll() {
        return Conversation::with('users')->get();
    }

    public static function send($data) {
        try {

            //make new conversation if data['conversation_id'] is not exist
            if(array_key_exists('conversation_id', $data)) {
                $conversation = Conversation::find($data['conversation_id']);
            } else {

                array_push($data['user'], $data['sender']);
                $convid = DB::table(static::$table)
                    ->join('conversation_user', 'conversation_user.conversation_id', '=', static::$table.".id")
                    ->where(function($query) use($data) {
                        foreach($data['user'] as $u) {
                            $query->where('conversation_user.user_id', '=', $u);
                        }
                    })
                    ->take(1)
                    ->only(static::$table.".id")
                    ;
                //dd($convid);

                //if already have conversation with list of user
                if($convid === false) {
                    $log = 'not found';
                    $conversation = Conversation::create(array(
                        'subject' => Utilities\Stringutils::snippet($data['message'])
                    ));

                    foreach($data['user'] as $u) {
                        $add = array();
                        if($u == $data['sender']) {
                            $add['read'] = true;
                        }
                        $conversation->users()->attach($u, $add);
                    }
                    $conversation->users()->sync($data['user']);

                } else {
                    $conversation = Conversation::find($convid);
                    $conversation->subject = Utilities\Stringutils::snippet($data['message']);
                    $conversation->save();

                    DB::table('conversation_user')
                        ->where('conversation_id', '=', $conversation->id)
                        ->where('user_id', '=', $data['sender'])
                        ->update(array(
                            'read' => true
                        ));
                    $log = $conversation;
                }

                //dd($log);

            }

            //create message
            foreach($data['user'] as $user) {
                $m = array(
                    'user_id' => $user,
                    'message' => $data['message']
                );
                if($user == $data['sender']) {
                    $m['read'] = true;
                }
                $message = new Message($m);
                $conversation->messages()->insert($message);
            }

            return $conversation;

        } catch (Exception $ex) {
            Log::exception($ex);
            dd($ex);
            return false;
        }
    }

    public function self() {
        $res = null;
        foreach($this->users()->pivot()->get() as $piv) {
            if($piv->user_id == Auth::user()->id) {
                //dd($piv);
                $res = $piv->to_array();
                break;
            }
        }
        return $res;
    }

    public function get_list_user() {
        $res = null;
        $i = sizeof($this->users);
        $j = 1;
        foreach($this->users as $u) {
            if($u->id != Auth::user()->id) {
                $res .= $u->name;
                if($j < $i )
                    $res .= ', ';
            }
            $j++;
        }
        return $res;
    }
}
