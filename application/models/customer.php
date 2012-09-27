<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fauziah
 * Date: 9/18/12
 * Time: 03:56 AM
 * To change this template use File | Settings | File Templates.
 */
class Customer extends Eloquent {

    public static $table = 'customer';
	
    public static $sqlformat = 'Y-m-d H:i:s';
		
	public function membership() {
        return $this->has_one('Member');
    }

	public function vehicles() {
		return $this->has_many('Vehicle', 'customer_id')
			->where('status','=',1);
	}

    public static function listAll($criteria) {
        return Customer::where('status', '=', 1)->get();
    }

    public static function update($id, $data = array()) {
        $customer = Customer::where_id($id)
            ->where_status(1)
            ->first();
        $customer->name = $data['name'];
        $customer->status = $data['status'];
		$customer->address1 = @$data['address1'];
		$customer->address2 = @$data['address2'];
		$customer->city = @$data['city'];
		$customer->post_code = @$data['post_code'];
		$customer->phone1 = @$data['phone1'];
		$customer->phone2 = @$data['phone2'];
		$customer->additional_info = @$data['additional_info'];
		
        //save
        $customer->save();

		//register membership
		if(isset($data['discount_id'])) {
			if($data['discount_id'] != '0')
				Customer::updateMembership($customer->id, $data);
			else
				$affected = DB::table('membership')
					->where('customer_id', '=', $customer->id)
					->delete();				
		}

		//register vehicles
		if(isset($data['vehicles']) && is_array($data['vehicles'])) {
			//cleanup membership
			$affected = DB::table('vehicle')
				->where('customer_id', '=', $customer->id)
				->delete();
			foreach($data['vehicles'] as $vehicle) {
				$customer->vehicles()->insert($vehicle);
			}
		}

        return $customer->id;
    }

    public static function create($data = array()) {
        $customer = new Customer;
        $customer->name = $data['name'];
        $customer->status = $data['status'];
		$customer->address1 = @$data['address1'];
		$customer->address2 = @$data['address2'];
		$customer->city = @$data['city'];
		$customer->post_code = @$data['post_code'];
		$customer->phone1 = @$data['phone1'];
		$customer->phone2 = @$data['phone2'];
		$customer->additional_info = @$data['additional_info'];
		
		//save
        $customer->save();
		
		/**
		array
		  'name' => string 'Adi Kurniawan' (length=13)
		  'address1' => string 'Puri Nirwana 1 Blok jj no 4 Cibinong' (length=36)
		  'address2' => string '' (length=0)
		  'city' => string 'Bogor' (length=5)
		  'post_code' => string '16916' (length=5)
		  'phone1' => string '' (length=0)
		  'phone2' => string '' (length=0)
		  'status' => string '1' (length=1)
		  'additional_info' => string '' (length=0)
		  'discount_id' => string '1' (length=1)
		  'vehicles' => 
		    array
		      0 => 
		        array
		          'number' => string 'F 4356 KF' (length=9)
		          'type' => string 'type' (length=4)
		          'color' => string 'type' (length=4)
		          'model' => string 'type' (length=4)
		          'brand' => string 'type' (length=4)
		          'description' => string 'type' (length=4)
		*/
		//register membership
		if(isset($data['discount_id'])) {
			if($data['discount_id'] != '0')
				Customer::updateMembership($customer->id, $data);
			else
				$affected = DB::table('membership')
					->where('customer_id', '=', $customer->id)
					->delete();				
		}
		
		//register vehicles
		if(isset($data['vehicles']) && is_array($data['vehicles'])) {
			//cleanup membership
			$affected = DB::table('vehicle')
				->where('customer_id', '=', $customer->id)
				->delete();
			foreach($data['vehicles'] as $vehicle) {
				$customer->vehicles()->insert($vehicle);
			}
		}
		
        return $customer->id;
    }

    public static function remove($id) {
        $customer = Customer::find($id);
        $customer->status = 0;
        $customer->save();
        return $customer->id;
    }

	public static function allWithMembership($criteria) {
        return Customer::with('membership')->get();
	}
	
	public static function updateMembership($id, $data) {
		$discount = Discount::find($data['discount_id'])->first();
		//dd($discount);
		$customer = Customer::find($id);
		
		//cleanup membership
		$affected = DB::table('membership')
			->where('customer_id', '=', $customer->id)
			->delete();
			//->update(array('status' => 'false'));
			
		//save membership
		$registration_date = date(static::$sqlformat);// registration_date
		$period = $discount->duration_period == 'M' ? 'month' : 
			( $discount->duration_period == 'Y' ? 'year' : 'seconds' );
		$value = $discount->duration;
		$expired = date(static::$sqlformat, 
			strtotime($registration_date . " +$value $period"));
		$membership_data = array(
			'discount_id'		=> $discount->id,
			'customer_id'		=> $customer->id,
			'number'			=> Member::member_new(),
			'status'			=> true,
			'registration_date'	=> $registration_date,
			'expiry_date'		=> $expired
		);
		//dd($membership_data);
		$customer->membership()->insert($membership_data);
		//dd($customer);
        return $customer->id;
	}
	
	public static function getForSelect() {
		$result = array();
		$rows = DB::query('select id, name from customer');
		foreach($rows as $row) {
			$result[$row->id] = $row->name;
		}
		return $result;
	}
	
}