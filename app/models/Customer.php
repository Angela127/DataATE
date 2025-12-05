<?php

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';

    // Get all customers
    public function all()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        return $this->query($sql);
    }

    // Find customer by ID
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE customer_id = :id";
        return $this->querySingle($sql, ['id' => $id]);
    }

    // Find by username
    public function findByUsername($username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username";
        return $this->querySingle($sql, ['username' => $username]);
    }

    // Find by email
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        return $this->querySingle($sql, ['email' => $email]);
    }

    // Find by matric number
    public function findByMatric($matric)
    {
        $sql = "SELECT * FROM {$this->table} WHERE matric_staff_no = :matric";
        return $this->querySingle($sql, ['matric' => $matric]);
    }

    // Create new customer (basic registration)
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (customer_id, username, matric_staff_no, email, password) 
                VALUES (:customer_id, :username, :matric_staff_no, :email, :password)";
        
        return $this->execute($sql, $data);
    }

    // Update profile (complete profile)
    public function updateProfile($id, $data)
    {
        $fields = [];
        $params = ['customer_id' => $id];

        // Build dynamic SQL based on provided fields
        if (isset($data['name'])) {
            $fields[] = "name = :name";
            $params['name'] = $data['name'];
        }
        if (isset($data['ic_passport'])) {
            $fields[] = "ic_passport = :ic_passport";
            $params['ic_passport'] = $data['ic_passport'];
        }
        if (isset($data['gender'])) {
            $fields[] = "gender = :gender";
            $params['gender'] = $data['gender'];
        }
        if (isset($data['faculty'])) {
            $fields[] = "faculty = :faculty";
            $params['faculty'] = $data['faculty'];
        }
        if (isset($data['residential_college'])) {
            $fields[] = "residential_college = :residential_college";
            $params['residential_college'] = $data['residential_college'];
        }
        if (isset($data['address'])) {
            $fields[] = "address = :address";
            $params['address'] = $data['address'];
        }
        if (isset($data['phone'])) {
            $fields[] = "phone = :phone";
            $params['phone'] = $data['phone'];
        }
        if (isset($data['parent_phone'])) {
            $fields[] = "parent_phone = :parent_phone";
            $params['parent_phone'] = $data['parent_phone'];
        }
        if (isset($data['license_no'])) {
            $fields[] = "license_no = :license_no";
            $params['license_no'] = $data['license_no'];
        }
        if (isset($data['license_expiry'])) {
            $fields[] = "license_expiry = :license_expiry";
            $params['license_expiry'] = $data['license_expiry'];
        }
        if (isset($data['license_image'])) {
            $fields[] = "license_image = :license_image";
            $params['license_image'] = $data['license_image'];
        }
        if (isset($data['identity_image'])) {
            $fields[] = "identity_image = :identity_image";
            $params['identity_image'] = $data['identity_image'];
        }
        if (isset($data['matric_staff_image'])) {
            $fields[] = "matric_staff_image = :matric_staff_image";
            $params['matric_staff_image'] = $data['matric_staff_image'];
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE customer_id = :customer_id";
        
        return $this->execute($sql, $params);
    }

    // Update customer status
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE {$this->table} SET status = :status WHERE customer_id = :id";
        return $this->execute($sql, ['id' => $id, 'status' => $status]);
    }

    // Update balance
    public function updateBalance($id, $amount)
    {
        $sql = "UPDATE {$this->table} SET balance = balance + :amount WHERE customer_id = :id";
        return $this->execute($sql, ['id' => $id, 'amount' => $amount]);
    }

    // Update password
    public function updatePassword($id, $hashedPassword)
    {
        $sql = "UPDATE {$this->table} SET password = :password WHERE customer_id = :id";
        return $this->execute($sql, ['id' => $id, 'password' => $hashedPassword]);
    }

    // Delete customer
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE customer_id = :id";
        return $this->execute($sql, ['id' => $id]);
    }

    // Search customers
    public function search($keyword)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE name LIKE :keyword 
                OR username LIKE :keyword 
                OR email LIKE :keyword 
                OR matric_staff_no LIKE :keyword
                OR phone LIKE :keyword
                ORDER BY created_at DESC";
        
        return $this->query($sql, ['keyword' => "%{$keyword}%"]);
    }

    // Check if profile is complete
    public function isProfileComplete($id)
    {
        $customer = $this->find($id);
        
        if (!$customer) {
            return false;
        }

        return !empty($customer->name) && 
               !empty($customer->ic_passport) && 
               !empty($customer->phone) && 
               !empty($customer->license_no) &&
               !empty($customer->license_image) &&
               !empty($customer->identity_image) &&
               !empty($customer->matric_staff_image);
    }
}