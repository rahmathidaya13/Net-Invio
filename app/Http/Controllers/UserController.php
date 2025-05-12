<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Traits\Validate\UserValidation;

class UserController extends Controller
{
    use UserValidation;
    public function index(Request $request)
    {
        // if (Gate::denies('AdminOnly')) {
        //     return back()->with('success', 'test');
        // }
        $limit = $request->get('limit', 10);
        $query = $request->get('keyword', '');
        $user = User::where('role', 'user')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'like', '%' . $query . '%')
                        ->orWhere('email', 'like', '%' . $query . '%');
                });
            })->latest()
            ->paginate($limit)
            ->appends(['keyword' => $query, 'limit' => $limit]);
        if ($request->ajax()) {
            return response()->json([
                'table' => view('User.partials.table', compact('user'))->render(),
                'pagination' => view('User.partials.pagination', compact('user'))->render(),
                'info' => [
                    'firstItem' => $user->firstItem(),
                    'lastItem' => $user->lastItem(),
                    'total' => $user->total(),
                ],
            ]);
        }
        return view("User.index", compact('user'));
    }
    public function create()
    {
        return view('User.forms.form');
    }
    public function store(Request $request)
    {
        $this->validationSave($request->all()); // validasi menggunakan traits
        if (
            !$request->has('can_add') &&
            !$request->has('can_edit') &&
            !$request->has('can_delete') &&
            !$request->has('can_view')
        ) {
            return back()->withErrors(['akses' => 'Minimal pilih salah satu hak akses harus dicentang'])->withInput();
        }
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->can_view = $request->boolean('can_view');
        $user->can_add = $request->boolean('can_add');
        $user->can_edit = $request->boolean('can_edit');
        $user->can_delete = $request->boolean('can_delete');
        $user->save();
        return redirect()->route('user.list')->with('success', 'Pengguna Baru ' . ucwords($request->name) . ' Berhasil Ditambahkan');
    }

    public function edit(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        return view('User.forms.form', compact('user'));
    }
    public function update(Request $request, string $id)
    {
        $this->validationUpdate($request->all(), $id); // validasi menggunakan traits

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->can_view = $request->boolean('can_view');
        $user->can_add = $request->boolean('can_add');
        $user->can_edit = $request->boolean('can_edit');
        $user->can_delete = $request->boolean('can_delete');
        if ($request->filled('password')) {
            $user['password'] = Hash::make($request->input('password'));
        }
        $user->update();
        return redirect()->route('user.list')->with('success', 'Pengguna ' . ucwords($user->name) . ' berhasil diperbarui.');
    }
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => 'Data terpilih berhasil dihapus'], 200);
    }
}
