<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Department;
use App\Models\Engineer;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('department_id') && $request->department_id != '' && $request->department_id != 'all') {
            $query->where('department_id', $request->department_id);
        }
        if ($request->has('engineer_id') && $request->engineer_id != '') {
            $query->where('engineer_id', $request->engineer_id);
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $books = $query->paginate(10);
        $books->appends($request->all());
        
        $departments = Department::get();
        $engineers = Engineer::get();

        return view('books.index', compact('books', 'departments', 'engineers'));
    }

    public function create()
    {
        $departments = Department::get();
        $engineers = Engineer::get();
        return view('books.create', compact('departments', 'engineers'));
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|exists:departments,id',
            'engineer_id' => 'required|exists:engineers,id',
            'type' => 'required|string|max:255',
            'status' => 'required|in:مستلم,قيد المراجعه,غير مستلم',
            'date' => 'required|date',
        ], [
            'department_id.required' => 'حقل القسم مطلوب.',
            'department_id.exists' => 'القسم المحدد غير موجود.',
            'engineer_id.required' => 'حقل المهندس مطلوب.',
            'engineer_id.exists' => 'المهندس المحدد غير موجود.',
            'type.required' => 'حقل النوع مطلوب.',
            'status.required' => 'حقل الحالة مطلوب.',
            'date.required' => 'حقل التاريخ مطلوب.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('books.create')->withInput();
        }

        // Create a new book record
        Book::create($request->all());

        $flasher->addSuccess('تم اضافة الكتاب بنجاح');
        return redirect()->route('books.index');
    }

    public function show($id)
    {
        $book = Book::with('department', 'engineer')->findOrFail($id);
        return view('books.show', compact('book'));
    }

    public function edit($id)
    {
        $book = Book::with('department', 'engineer')->findOrFail($id);
        $departments = Department::get();
        $engineers = Engineer::get();

        return view('books.edit', compact('book', 'departments', 'engineers'));
    }

    public function update(Request $request, FlasherInterface $flasher, $id)
    {
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|exists:departments,id',
            'engineer_id' => 'required|exists:engineers,id',
            'type' => 'required|string|max:255',
            'status' => 'required|in:مستلم,قيد المراجعه,غير مستلم',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('books.edit', $id)->withInput();
        }

        $book = Book::findOrFail($id);
        $book->update($request->all());

        $flasher->addSuccess('تم تعديل الكتاب بنجاح');
        return redirect()->route('books.index');
    }

    public function destroy(Request $request, FlasherInterface $flasher)
    {
        $book = Book::findOrFail($request->book_id);

        try {
            $book->delete();
            $flasher->addError('تم حذف الكتاب بنجاح');
        } catch (\Exception $e) {
            $flasher->addError('حدث خطأ اثناء الحذف');
        }

        return redirect()->route('books.index');
    }


}
