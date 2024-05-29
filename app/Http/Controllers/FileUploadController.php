<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function fileUpload()
    {
        return view('file-upload');
    }
    public function prosesFileUpload(Request $request)
    {
        // ?
        //dump($request->file('file'));
        //return "Pemrosesan file upload di sini";

        // if ($request->hasFile('berkas')) {
        //     echo "path(): " . $request->berkas->path();
        //     echo "<br>";
        //     echo "extension(): " . $request->berkas->extension();
        //     echo "<br>";
        //     echo "getClientOriginalExtension(): " . $request->berkas->getClientOriginalExtension();
        //     echo "<br>";
        //     echo "getMimeType(): " . $request->berkas->getMimeType();
        //     echo "<br>";
        //     echo "getClientOriginalName(): " . $request->berkas->getClientOriginalName();
        //     echo "<br>";
        //     echo "getSize(): " . $request->berkas->getSize();
        // } else {
        //     echo "Tidak ada berkas yang diupload";
        // }

        $request->validate([
            'berkas'=>'required|file|image|max:500',]);
        $textFile = $request->berkas->getClientOriginalName();
        $namaFile ='web'.time().".".$textFile;

        $path = $request->berkas->move('gambar', $namaFile);
        $path = str_replace("\\","//", $path);
        echo "variable path berisi:$path <br>";

        $pathBaru=asset('gambar/'.$namaFile);
        echo "proses upload berhasil, data disimpan pada:$path";
        echo "<br>";
        echo "Tampilkan link: <a href='$pathBaru'>$pathBaru</a>";
        // echo $request->berkas->getClientOriginalName()."lolos validasi";

    }
}