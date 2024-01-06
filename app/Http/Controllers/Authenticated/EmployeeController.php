<?php

namespace App\Http\Controllers\Authenticated;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Job;
use App\Models\JobLevel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * @var array
     */
    private array $genders = [
        "Pria" => "Pria",
        "Wanita" => "Wanita",
    ];

    /**
     * @var array
     */
    private array $bloodGroups = [
        "A" => "A",
        "B" => "B",
        "AB" => "AB",
        "O" => "O",
    ];

    /**
     * @var array
     */
    private array $maritalStatus = [
        "Belum Menikah" => "Belum Menikah",
        "Menikah" => "Menikah",
        "Duda / Janda" => "Duda / Janda",
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::with(['user', 'job'])->orderBy('created_at')->get();

        $data = [
            'employees' => $employees,
        ];

        return view('employee.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'jobLevels' => JobLevel::all(),
            'genders' => $this->genders,
            'bloodGroups' => $this->bloodGroups,
            'maritalStatus' => $this->maritalStatus,
        ];

        return view('employee.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => ['required', 'unique:employees'],
            'phone' => ['required'],
            'ktp' => ['required', 'unique:employees'],
            'ktp_address' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
            'job_level' => ['required'],
            'job' => ['required'],
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
            'password_confirmation' => ['required', 'same:password'],
        ]);

        $job_level_id = $request->input('job_level');
        $job_id = $request->input('job');
        $role = JobLevel::find($job_level_id)->role;

        $superior_id = $request->input('superior', false);

        $request->merge([
            'password' => Hash::make($request->input('password')),
        ]);

        $user = User::create($request->all());
        $user->assignRole($role);

        $employee = new Employee($request->all());
        $employee->user()->associate($user);
        $employee->jobLevel()->associate($job_level_id);
        $employee->job()->associate($job_id);

        if ($superior_id) {
            $employee->superior()->associate($superior_id);
        }

        $employee->save();

        return redirect()->route('employees')->with('success', 'Berhasil menambahkan karyawan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::with([
            'user', 'job', 'job.jobLevel',
            'superior', 'superior.user', 'superior.job',
            'subordinates', 'subordinates.user', 'subordinates.job',
        ])->find($id);

        if (!$employee) {
            return abort(404);
        }

        $data = [
            'employee' => $employee,
        ];

        return view('employee.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $genders = $this->genders;
        $bloodGroups = $this->bloodGroups;
        $maritalStatus = $this->maritalStatus;
        $jobLevels = JobLevel::all();
        $employees = Employee::find($id);
        return view('employee.edit', compact('employees','jobLevels','genders','bloodGroups','maritalStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $employees = Employee::findOrFail($id);
        $employees->nik = $request->nik;
        $employees->phone = $request->phone;
        $employees->ktp = $request->ktp;
        $employees->ktp_address = $request->ktp_address;
        $employees->city = $request->city;
        $employees->address = $request->address;
        $employees->place_of_birth = $request->place_of_birth;
        $employees->date_of_birth = $request->date_of_birth;
        $employees->religion = $request->religion;
        $employees->gender = $request->gender;
        $employees->blood_group = $request->blood_group;
        $employees->marital_status = $request->marital_status;
        $employees->job_level_id = $request->job_level;

        // $employees->job = $request->job; // Field Kosong

        $user = User::findOrFail($employees->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->password = $request->password;
        $user->save();
        $employees->save();

        return redirect()->route('employees')->with('success', 'Berhasil mengedit data karyawan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->route('employees')->with('success', 'Berhasil menghapus karyawan.');
    }
}
