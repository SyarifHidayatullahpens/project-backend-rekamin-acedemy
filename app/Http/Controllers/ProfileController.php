<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ProfilStudentRequest;
use App\Http\Requests\ResetPasswordRequest;
use DB;
use Image;
use Hash;

class ProfileController extends Controller
{
    public function profileTeacher(ProfileRequest $request)
    {
        $data = $request->validated();

        if (auth()->user()->id != $request->id || $this->getTeacher()->nip != $request->nip) {
            return response()->json([
                'success' => false,
                'message' => "Terdeteksi peretasan",
            ], 409);
        }
        DB::beginTransaction();
        try {
            if (!isset($data['photo'])) {
                $data['photo'] = User::select('photo')->where('id', $request->id)->first()->photo;
            }
            if($request->file('photo')){
                $path = 'storage/img';
                $file = $request->file('photo');
                $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
                $imageFile = Image::make($file->getRealPath());
                $imageFile->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                })->crop(600,600)->save($path.'/'.$file_name,80);
                $data['photo'] = $path.'/'.$file_name;
            }

            User::where('id', $request->id)->update([
                'username'  => $data['username'],
                'email'     => $data['email'],
                'photo'     => $data['photo'],
            ]);

            Teacher::updateOrCreate(
                [
                    'nip' => $data['nip'],
                ],
                [
                    'name'      => $data['name'],
                    'address'   => $data['address'],
                    'birthplace'=> $data['birthplace'],
                    'birthdate' => $data['birthdate'],
                    'gender'    => $data['gender'],
                    'phone'     => $data['phone'],
                    'religion'  => $data['religion'],
                ]
            );
            DB::commit();
            return response()->json([
                'success'=> true,
                'message' => "Profil berhasil diperbarui!"
            ],200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Profil gagal diperbarui!',
            ], 409);
        }
    }

    public function profileStudent(ProfilStudentRequest $request)
    {
        $data = $request->validated();

        if (auth()->user()->id != $request->id || $this->getStudent()->nis != $request->nis) {
            return response()->json([
                'success' => false,
                'message' => "Terdeteksi peretasan",
            ], 409);
        }
        DB::beginTransaction();
        try {
            if (!isset($data['photo'])) {
                $data['photo'] = User::select('photo')->where('id', $request->id)->first()->photo;
            }
            if($request->file('photo')){
                $path = 'storage/img';
                $file = $request->file('photo');
                $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
                $imageFile = Image::make($file->getRealPath());
                $imageFile->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                })->crop(600,600)->save($path.'/'.$file_name,80);
                $data['photo'] = $path.'/'.$file_name;
            }

            User::where('id', $request->id)->update([
                'username'  => $data['username'],
                'email'     => $data['email'],
                'photo'     => $data['photo'],
            ]);

            Student::updateOrCreate(
                [
                    'nis' => $data['nis'],
                ],
                [
                    'name'      => $data['name'],
                    'address'   => $data['address'],
                    'birthplace'=> $data['birthplace'],
                    'birthdate' => $data['birthdate'],
                    'gender'    => $data['gender'],
                    'phone'     => $data['phone'],
                    'religion'  => $data['religion'],
                ]
            );
            DB::commit();
            return response()->json([
                'success'=> true,
                'message' => "Profil berhasil diperbarui!"
            ],200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Profil gagal diperbarui",
            ], 409);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('id', auth()->user()->id)->first();

        if ($user) {
            if(Hash::check($request->old_password, $user->password)) {
                $user->update([
                    'password' => bcrypt($request->new_password)
                ]);
                $removeToken = $request->user()->tokens()->delete();
                return response()->json([
                    'success'=> true,
                    'message' => "Password berhasil diperbarui!"
                ],200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Password lama tidak sesuai",
                ], 409);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => "User tidak ditemukan",
            ], 409);
        }
    }

    private function getTeacher()
    {
        $teacher = Teacher::where('user_id', auth()->user()->id)->first();
        return $teacher;
    }

    private function getStudent()
    {
        $student = Student::where('user_id', auth()->user()->id)->first();
        return $student;
    }
}
