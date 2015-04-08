<?php

class Orders_model extends CI_Model {
    var $user_id;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();
    }

    /**
    * Save Domain Orders
    * @param array $data
    * @return int db insert id
    */
    public function save($data) {
    	$data['user_id'] = $this->user_id;
        $this->db->insert('domain_orders', $data);

        return $this->db->insert_id();
    }

    /**
    * Check user auth
	*/

	public function check_auth($site_id) {
       $this->db->select('site_id');
       $query = $this->db->get_where('sites', array('site_id' => (int) $site_id, 'user_id' => $this->user_id));
       $count = $query->num_rows();
       $statu = $this->auth->get_statu();
      //sitenin sahibi ya da admin degilse
       if($count != 1 ){
            $this->output->set_status_header('401');           
           echo "Opps. Yetki hatasi";
           die;
       }
	}

    public function get_order_count(){
        $this->db->where('status', 0);
        $this->db->or_where('status', 1);
        $query = $this->db->get('domain_orders');    
        return $query->num_rows();
    }
    
    /**
    * Getter for orders
    * @param int $limit
    * @param int $where
    * @return object array
    */
    public function get_orders($limit, $where){
        $this->db->limit($limit, $where);
        $this->db->where('status', 0);
        $this->db->or_where('status', 1);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('domain_orders');
        $result = $query->result();
       
        //okunmayanları okundu olarak isaretle
        $this->db->limit($limit, $where);
        $this->db->where('status', 0);
        $this->db->update('domain_orders', array('status' => 1));
        return $result;
    }

    public function close($order_id) {
        $this->db->where('id', $order_id);
        $this->db->update('domain_orders', array('status' => 2));   
    }

    public function reject($order_id) {
        $this->db->where('id', $order_id);
        $this->db->update('domain_orders', array('status' => 3));         
    }

    public function  get_user_orders($user_id = null) {
        if($user_id == null) {
            $user_id = $this->user_id;
        }
        $this->db->select('domain_orders.id as id, domain_orders.created_at as created_at, domain_orders.external_registerer as external_registerer, domain_orders.domain as domain, domain_orders.package as package, packages.price as price, domain_orders.status as status, domain_orders.user_read');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('domain_orders.id', 'desc');
        $this->db->from('domain_orders');
        $this->db->join('packages', 'packages.name = domain_orders.package', 'inner');
        $query = $this->db->get();
        $result = $query->result();
        
        $data = array();
        foreach($result as $row) {
            $price = $row->price;
            if($row->external_registerer) {
                $price -= 20;
            }
            $data[] = array(
                'id' => $row->id,
                'package' => $row->package,
                'domain' => $row->domain,
                'price' => $price,
                'date' => $row->created_at,
                'user_read' => $row->user_read,
                'status' => $row->status
            );
        };

        return $data;       
    }

    public function update_unread($user_id) {
        $this->db->where(array('user_id' => $user_id, 'user_read' => 0));
        $this->db->update('domain_orders', array('user_read' => true));
        return true;
    }
    public function get_unread_orders($user_id){
        $this->db->where('user_id', $user_id);
        $this->db->where('user_read', 0);
        $query = $this->db->get('domain_orders');    
        return $query->num_rows();
    }

    /**
    * Getter for order by order id
    * @param int $id , order id
    * @return object
    */
    public function get_order_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('domain_orders');
        return $query->row();
    }
}