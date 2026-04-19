<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',


    'inactive' => [
        'title' => 'Account status',
        'titles' => [
            'pending'   => 'Awaiting approval',
            'approved'  => 'Active',
            'suspended' => 'Suspended',
            'blocked'   => 'Blocked',
            'rejected'  => 'Rejected',
            'unknown'   => 'Inactive',
        ],
        'messages' => [
            'pending'   => 'Your account has been created and is awaiting administrator approval. We will notify you by email once it is activated.',
            'approved'  => 'Your account is active. You can continue using the system.',
            'suspended' => 'Your account is temporarily suspended. Please contact support for assistance.',
            'blocked'   => 'Your account has been blocked. If you believe this is a mistake, please contact support.',
            'rejected'  => 'Your registration has been rejected. Contact support if you need more information.',
            'unknown'   => 'Your account is inactive. Please contact support.',
        ],

        // ðŸ”‘ Newly added keys
        'use_official_email'     => 'Please use your official university email when registering or contacting support.',
        'contact_support_hint'   => 'If you need help, contact support and include your full name, department, and university email.',
        'policy_note'            => 'This action may violate policy. For details, please contact support.',
        'verify_email_resend'    => 'Resend verification email',

        'contact_support' => 'Contact support',
        'back_to_login'   => 'Back to login',
    ],



    'common' => [
        'secure' => 'Secure',
        'note' => 'Note',
        'pending_note' => 'After registration, admin approval is required before you can access the system.',
        'admin_note_title' => 'Admins',
        'admin_note_desc' => 'Admin accounts are created by system administrators only.',
        'privacy_note' => 'We only use your university email to verify access.',
        'built_by' => 'Built by',
        'please_wait' => 'Please wait...',
        'too_many_attempts' => 'Too many attempts, try again later.',
    ],



    'login' => [
        'title' => 'Sign in',
        'subtitle' => 'Use your account credentials to access the portal.',
        'login_field' => 'Username, Email, or Phone',
        'password' => 'Password',
        'remember' => 'Remember me',
        'forgot' => 'Forgot your password?',
        'btn' => 'Log in',
    ],

    'forgot' => [
        'title' => 'Forgot password',
        'subtitle' => 'Enter your email and we will send you a reset link.',
        'email' => 'Email',
        'btn' => 'Send reset link',
        'back' => 'Back to login',
    ],

    'reset' => [
        'title' => 'Reset password',
        'subtitle' => 'Choose a new password.',
        'email' => 'Email',
        'password' => 'New password',
        'confirm_password' => 'Confirm password',
        'btn' => 'Reset password',
    ],


    'register' => [
        'title' => 'Employee / Teacher Registration',
        'subtitle' => 'Use your university email. Your request will be reviewed by the admin.',
        'name' => 'Full name',
        'username' => 'Username',
        'phone' => 'Phone',
        'university_email' => 'University email',
        'password' => 'Password',
        'confirm_password' => 'Confirm password',
        'department_type' => 'Department type',
        'academic' => 'Academic (Teacher)',
        'administrative' => 'Administrative (Employee)',
        'department' => 'Department',
        'gender' => 'Gender',
        'male' => 'Male',
        'female' => 'Female',
        'birthday' => 'Birthday',
        'address' => 'Address',
        'accept_terms' => 'I confirm the information is correct.',
        'sign_up' => 'Sign up',
        'have_account' => 'Already have an account?',
        'sign_in' => 'Sign in',
        'pending_msg' => 'Your registration is pending approval.',
    ],
];
