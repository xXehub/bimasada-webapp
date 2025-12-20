<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stats = [
            'total' => User::count(),
            'active' => User::whereNotNull('email_verified_at')->count(),
            'pending' => User::whereNull('email_verified_at')->count(),
            'admins' => User::role('Marketing Manager')->count(),
        ];
        
        return view('users.index', compact('stats'));
    }

    /**
     * DataTables server-side processing
     */
    public function getData(Request $request)
    {
        $query = User::with('roles');

        return DataTables::of($query)
            ->addColumn('roles', function ($user) {
                if ($user->roles->isEmpty()) {
                    return '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                No Role
                            </span>';
                }
                
                return $user->roles->map(function($role) {
                    // Color mapping based on role
                    $colorMap = [
                        'Marketing Manager' => ['bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-700 dark:text-purple-400'],
                        'Sales' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-400'],
                    ];
                    
                    $colors = $colorMap[$role->name] ?? ['bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-700 dark:text-gray-300'];
                    
                    return '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold '.$colors['bg'].' '.$colors['text'].'">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                '.$role->name.'
                            </span>';
                })->join(' ');
            })
            ->addColumn('status', function ($user) {
                if ($user->email_verified_at) {
                    return '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                Active
                            </span>';
                }
                
                return '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            Pending
                        </span>';
            })
            ->addColumn('action', function ($user) {
                return '
                    <div class="flex items-center justify-center gap-1">
                        <a href="'.route('users.edit', $user->id).'" class="p-2 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <button type="button" onclick="deleteUser('.$user->id.')" class="p-2 rounded-lg text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Delete">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['roles', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        
        $user = User::create($validated);
        
        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }
        
        return redirect()->route('users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('roles.permissions');
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        
        // Only update password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        $user->update($validated);
        
        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }
        
        return redirect()->route('users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account!'
            ], 403);
        }
        
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully!'
        ]);
    }
}
