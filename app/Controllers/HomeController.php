<?php

namespace App\Controllers;

use Core\Controller;
use Core\Http\Request;
use Core\Http\Response;
use App\Models\User;

/**
 * Home Controller
 * Example controller showing clear code flow
 */
class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index(Request $request): Response
    {
        return $this->view('home', [
            'title' => 'Welcome to PHP MVC Framework',
            'message' => 'A simple, native PHP MVC framework with robust routing'
        ]);
    }

    /**
     * Display about page
     */
    public function about(Request $request): Response
    {
        return $this->view('about', [
            'title' => 'About Us'
        ]);
    }

    /**
     * Example API endpoint
     */
    public function api(Request $request): Response
    {
        return $this->json([
            'message' => 'Welcome to the API',
            'version' => '1.0.0',
            'framework' => 'PHP MVC'
        ]);
    }

    /**
     * Example: Get all users
     * Shows clear flow: Controller -> Model -> Database
     */
    public function users(Request $request): Response
    {
        // Step 1: Load the User model
        $userModel = $this->loadModel(User::class);

        // Step 2: Call model method to get data
        $users = $userModel->getAllUsers();

        // Step 3: Return JSON response
        return $this->json([
            'success' => true,
            'users' => $users
        ]);
    }

    /**
     * Example: Get single user by ID
     * Shows route parameter usage
     */
    public function showUser(Request $request, $id): Response
    {
        // Load model
        $userModel = $this->loadModel(User::class);

        // Get user from database
        $user = $userModel->getUserById($id);

        // Check if user exists
        if (!$user) {
            return $this->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        // Return user data
        return $this->json([
            'success' => true,
            'user' => $user
        ]);
    }

    /**
     * Example: Create new user
     * Shows POST request handling
     */
    public function createUser(Request $request): Response
    {
        // Get input data from request
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        // Validate input
        if (!$name || !$email || !$password) {
            return $this->json([
                'success' => false,
                'message' => 'Name, email and password are required'
            ], 400);
        }

        // Load model
        $userModel = $this->loadModel(User::class);

        // Create user in database
        $userId = $userModel->createUser($name, $email, $password);

        // Return success response
        return $this->json([
            'success' => true,
            'message' => 'User created successfully',
            'user_id' => $userId
        ], 201);
    }

    /**
     * Example: Update user
     */
    public function updateUser(Request $request, $id): Response
    {
        // Get input
        $name = $request->input('name');
        $email = $request->input('email');

        // Load model
        $userModel = $this->loadModel(User::class);

        // Update user
        $updated = $userModel->updateUser($id, $name, $email);

        if ($updated) {
            return $this->json([
                'success' => true,
                'message' => 'User updated successfully'
            ]);
        }

        return $this->json([
            'success' => false,
            'message' => 'Failed to update user'
        ], 400);
    }

    /**
     * Example: Delete user
     */
    public function deleteUser(Request $request, $id): Response
    {
        // Load model
        $userModel = $this->loadModel(User::class);

        // Delete user
        $deleted = $userModel->deleteUser($id);

        if ($deleted) {
            return $this->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        }

        return $this->json([
            'success' => false,
            'message' => 'Failed to delete user'
        ], 400);
    }
}
