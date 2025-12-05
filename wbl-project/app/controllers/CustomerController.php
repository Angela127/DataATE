<?php

class CustomerController extends Controller
{
    private $customerModel;

    public function __construct()
    {
        // Load the customer model
        $this->customerModel = new Customer();
    }

    // ==================== REGISTRATION ====================
    
    // Show registration form
    public function register()
    {
        // If already logged in, redirect to home
        if (isset($_SESSION['customer_id'])) {
            $this->redirect('/');
            return;
        }
        
        $this->view('customers/register');
    }

    // Process registration
    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize inputs
            $data = [
                'username' => trim($_POST['username']),
                'matric_staff_no' => trim($_POST['matric_staff_no']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password'])
            ];

            // Validation
            $errors = [];

            // Username validation
            if (empty($data['username'])) {
                $errors[] = 'Username is required.';
            } elseif (strlen($data['username']) < 3 || strlen($data['username']) > 20) {
                $errors[] = 'Username must be between 3 and 20 characters.';
            } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
                $errors[] = 'Username can only contain letters, numbers, and underscores.';
            }

            // Matric/Staff number validation
            if (empty($data['matric_staff_no'])) {
                $errors[] = 'Matric/Staff number is required.';
            } elseif (strlen($data['matric_staff_no']) > 9) {
                $errors[] = 'Matric/Staff number must be maximum 9 characters.';
            }

            // Email validation
            if (empty($data['email'])) {
                $errors[] = 'Email is required.';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format.';
            }

            // Password validation
            if (empty($data['password'])) {
                $errors[] = 'Password is required.';
            } elseif (strlen($data['password']) < 6) {
                $errors[] = 'Password must be at least 6 characters long.';
            }

            // Confirm password
            if ($data['password'] !== $data['confirm_password']) {
                $errors[] = 'Passwords do not match.';
            }

            // Check for existing username, email, matric_no
            if ($this->customerModel->findByUsername($data['username'])) {
                $errors[] = 'Username already exists.';
            }

            if ($this->customerModel->findByEmail($data['email'])) {
                $errors[] = 'Email already exists.';
            }

            if ($this->customerModel->findByMatric($data['matric_staff_no'])) {
                $errors[] = 'Matric/Staff number already exists.';
            }

            // If there are errors, redirect back with errors
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $data;
                $this->redirect('/customers/register');
                return;
            }

            // Hash password
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            // Prepare data for database
            $customerData = [
                'customer_id' => $this->generateCustomerId(),
                'username' => $data['username'],
                'matric_staff_no' => $data['matric_staff_no'],
                'email' => $data['email'],
                'password' => $hashedPassword
            ];

            // Create customer
            if ($this->customerModel->create($customerData)) {
                $this->setFlash('Registration successful! Please login.');
                $this->redirect('/customers/login');
            } else {
                $this->setFlash('Registration failed. Please try again.', 'Error');
                $this->redirect('/customers/register');
            }

        } else {
            $this->redirect('/customers/register');
        }
    }

    // ==================== LOGIN ====================
    
    // Show login form
    public function login()
    {
        // If already logged in, redirect
        if (isset($_SESSION['customer_id'])) {
            $this->redirect('/');
            return;
        }
        
        $this->view('customers/login');
    }

    // Process login
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // Validation
            if (empty($username) || empty($password)) {
                $this->setFlash('Please fill in all fields.', 'Error');
                $this->redirect('/customers/login');
                return;
            }

            // Find user
            $customer = $this->customerModel->findByUsername($username);

            if ($customer && password_verify($password, $customer->password)) {
                
                // Check if account is blacklisted
                if ($customer->status === 'Blacklisted') {
                    $this->setFlash('Your account has been suspended. Please contact support.', 'Error');
                    $this->redirect('/customers/login');
                    return;
                }

                // Set session
                $_SESSION['customer_id'] = $customer->customer_id;
                $_SESSION['username'] = $customer->username;
                $_SESSION['email'] = $customer->email;
                $_SESSION['status'] = $customer->status;

                $this->setFlash('Welcome back, ' . $customer->username . '!');
                $this->redirect('/');
            } else {
                $this->setFlash('Invalid username or password.', 'Error');
                $this->redirect('/customers/login');
            }

        } else {
            $this->redirect('/customers/login');
        }
    }

    // Logout
    public function logout()
    {
        session_destroy();
        $this->setFlash('You have been logged out successfully.');
        $this->redirect('/customers/login');
    }

    // ==================== PROFILE ====================
    
    // View profile
    public function profile()
    {
        if (!isset($_SESSION['customer_id'])) {
            $this->redirect('/customers/login');
            return;
        }

        $customer = $this->customerModel->find($_SESSION['customer_id']);

        if (!$customer) {
            $this->setFlash('Customer not found.', 'Error');
            $this->redirect('/customers/login');
            return;
        }

        $this->view('customers/profile', ['customer' => $customer]);
    }

    // Show complete/edit profile form
    public function edit()
    {
        if (!isset($_SESSION['customer_id'])) {
            $this->redirect('/customers/login');
            return;
        }

        $customer = $this->customerModel->find($_SESSION['customer_id']);

        if (!$customer) {
            $this->setFlash('Customer not found.', 'Error');
            $this->redirect('/customers/login');
            return;
        }

        $this->view('customers/edit', ['customer' => $customer]);
    }

    // Update profile
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Check if logged in
            if (!isset($_SESSION['customer_id'])) {
                $this->redirect('/customers/login');
                return;
            }

            $data = [
                'name' => trim($_POST['name']),
                'ic_passport' => trim($_POST['ic_passport']),
                'gender' => $_POST['gender'],
                'faculty' => trim($_POST['faculty']),
                'residential_college' => trim($_POST['residential_college']),
                'address' => trim($_POST['address']),
                'phone' => trim($_POST['phone']),
                'parent_phone' => trim($_POST['parent_phone']),
                'license_no' => trim($_POST['license_no']),
                'license_expiry' => $_POST['license_expiry']
            ];

            // Handle file uploads
            $uploadPath = 'public/uploads/customers/';
            
            // Create directory if not exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Upload license image
            if (isset($_FILES['license_image']) && $_FILES['license_image']['error'] == 0) {
                $licenseName = uniqid() . '_' . basename($_FILES['license_image']['name']);
                $licensePath = $uploadPath . $licenseName;
                
                if (move_uploaded_file($_FILES['license_image']['tmp_name'], $licensePath)) {
                    $data['license_image'] = $licenseName;
                }
            }

            // Upload identity image
            if (isset($_FILES['identity_image']) && $_FILES['identity_image']['error'] == 0) {
                $identityName = uniqid() . '_' . basename($_FILES['identity_image']['name']);
                $identityPath = $uploadPath . $identityName;
                
                if (move_uploaded_file($_FILES['identity_image']['tmp_name'], $identityPath)) {
                    $data['identity_image'] = $identityName;
                }
            }

            // Upload matric/staff image
            if (isset($_FILES['matric_staff_image']) && $_FILES['matric_staff_image']['error'] == 0) {
                $matricName = uniqid() . '_' . basename($_FILES['matric_staff_image']['name']);
                $matricPath = $uploadPath . $matricName;
                
                if (move_uploaded_file($_FILES['matric_staff_image']['tmp_name'], $matricPath)) {
                    $data['matric_staff_image'] = $matricName;
                }
            }

            // Update customer profile
            if ($this->customerModel->updateProfile($_SESSION['customer_id'], $data)) {
                $this->setFlash('Profile updated successfully!');
                $this->redirect('/customers/profile');
            } else {
                $this->setFlash('Error updating profile.', 'Error');
                $this->redirect('/customers/edit');
            }

        } else {
            $this->redirect('/customers/edit');
        }
    }

    // ==================== ADMIN FUNCTIONS ====================
    
    // Show all customers (Admin only)
    public function index()
    {
        $customers = $this->customerModel->all();
        $this->view('customers/index', ['customers' => $customers]);
    }

    // View customer details (Admin)
    public function show($id)
    {
        $customer = $this->customerModel->find($id);

        if (!$customer) {
            $this->setFlash('Customer not found.', 'Error');
            $this->redirect('/customers/index');
            return;
        }

        $this->view('customers/show', ['customer' => $customer]);
    }

    // Delete customer (Admin)
    public function destroy($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($this->customerModel->delete($id)) {
                $this->setFlash('Customer deleted successfully!');
            } else {
                $this->setFlash('Error deleting customer.', 'Error');
            }

        }

        $this->redirect('/customers/index');
    }

    // ==================== HELPER FUNCTIONS ====================
    
    // Generate unique customer ID
    private function generateCustomerId()
    {
        return 'CUST' . date('Ymd') . rand(1000, 9999);
    }
}