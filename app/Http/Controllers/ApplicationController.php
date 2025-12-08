<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Status;
use App\Models\TypeBuy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    // Список заявок текущего пользователя
    public function index()
    {
        $applications = Application::with(['status', 'typeBuy'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('applications.index', compact('applications'));
    }

    // Админка: список всех заявок
    public function adminIndex()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещён.');
        }

        $applications = Application::with(['user', 'status', 'typeBuy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('applications.admin', compact('applications'));
    }

    // Админка: одобрить заявку
    public function approve($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещён.');
        }
        $app = Application::findOrFail($id);
        $app->status_id = 2; // Статус "одобрена"
        $app->save();
        return back()->with('success', 'Заявка одобрена!');
    }

    // Админка: отклонить заявку (удалить)
    public function decline($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещён.');
        }
        $app = Application::findOrFail($id);
        $app->delete();
        return back()->with('success', 'Заявка удалена!');
    }

    public function approvedList()
    {
        $applications = Application::with(['status', 'typeBuy', 'user'])
            ->where('status_id', 2) // статус "одобрена"
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', compact('applications'));
    }

    // Форма создания заявки
    public function create()
    {
        $statuses = Status::all();
        $typeBuys = TypeBuy::all();
        return view('applications.create', compact('statuses', 'typeBuys'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'address'     => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:20',
            'count_rooms' => 'required|integer|min:1',
            'price'       => 'required|integer|min:0',
            'path_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type_buy_id' => 'required|integer|exists:type_buy,id',
        ]);

        if ($request->hasFile('path_image')) {
            $path = $request->file('path_image')->store('applications', 'public');
            $data['path_image'] = $path;
        } else {
            $data['path_image'] = null;
        }

        $data['status_id'] = 1;
        $data['user_id'] = Auth::id();

        Application::create($data);

        return redirect()->route('applications.index')->with('success', 'Заявка успешно создана!');
    }

    // Просмотр одной заявки
    public function show(Application $application)
    {
        if ($application->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещён.');
        }

        return view('applications.show', compact('application'));
    }
}
