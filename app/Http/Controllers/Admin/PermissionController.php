<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public  function __construct()
    {
         $this->middleware('can:permission list', ['only' => ['index','show']]);
         $this->middleware('can:permission create', ['only' => ['create','store']]);
         $this->middleware('can:permission edit', ['only' => ['edit','update']]);
         $this->middleware('can:permission delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $permissions = Permission::latest()->paginate(5);
        return view('admin.permission.index',compact('permissions'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:'.config('permission.table_names.permissions', 'permissions').',name',
        ]);
        Permission::create($request->all());
        return redirect()->route('permission.index')
                        ->with('message','Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return view('admin.permission.show',compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permission.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:'.config('permission.table_names.permissions', 'permissions').',name,'.$permission->id,
        ]);
        $permission->update($request->all());
        return redirect()->route('permission.index')
                        ->with('message','Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permission.index')
                        ->with('message','Permission deleted successfully');
    }
}
