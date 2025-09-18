@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 mt-3">
            <div class="card">
                <div class="card-header">{{ __('Panduan Penggunaan Aplikasi') }}</div>
                <div class="card-body">
                    @auth
                        @if (Auth::user()->hasRole('Administrator'))
                            <h3>Bagian Admin</h3>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h5>Data Karyawan</h5>
                                    <!-- cara melihat data karyawan -->
                                    <h6>Cara Melihat Data Karyawan</h6>
                                    <ol>
                                        <li><span class="me-1">Akses data karyawan dengan menekan tombol data karyawan pada
                                                kiri atas atau buka
                                                menu di kanan atas terlebih dahulu jika melalui smartphone.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan1.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li>Jika sudah, maka akan muncul tampilan seperti dibawah ini dan
                                            bisa melihat
                                            informasi
                                            karyawan secara umum seperti nama, jabatan, dan lainnya.</li>
                                        <img src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan2.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <!-- cara menambahkan data karyawan -->
                                    <h6>Cara Menambahkan Data Karyawan</h6>
                                    <ol>
                                        <li><span class="me-1">Akses modal untuk menambah data karyawan dengan klik tombol
                                                tambah di kanan atas</span><img
                                                src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan3.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li>Lalu akan muncul modal seperti dibawah ini. Isi semua inputan sesuai dengan aturan
                                            yang ada, jangan lupe membaca notes di paling bawah modal untuk mengetahui informasi
                                            penting tambahan.</li>
                                        <img src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan3,1.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                        <li><span class="me-1">Jika semua dianggap sudah sesuai maka klik tombol Simpan Data
                                                di paling kanan bawah
                                                modal</span> <img
                                                src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan3,2.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan3,3.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                        <li>Kembali ke halaman awal dan cek perubahan / penambahan data karyawan yang ada.</li>
                                    </ol>
                                    <h6>Cara Mengekspor Data Karyawan ke Dalam Bentuk PDF</h6>
                                    <ol>
                                        <li><span class="me-1">Tekan tombol pdf di sebelah tombol tambah</span><img
                                                src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan4.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span class="me-1">Lalu akan muncul pemberitahuan download seperti ini dan tinggal
                                                simpan
                                                saja</span><img
                                                src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan4,1.png') }}"
                                                alt="" class="rounded" style="height: 8vh"></li>
                                    </ol>
                                    <h6>Cara Mengekspor Data Karyawan ke Dalam Bentuk Excel</h6>
                                    <ol>
                                        <li><span class="me-1">Tekan tombol excel di sebelah kiri tombol export PDF / download
                                                PDF</span><img
                                                src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan5.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span class="me-1">Lalu akan muncul pemberitahuan download seperti ini dan tinggal
                                                simpan
                                                saja</span><img
                                                src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan5,1.png') }}"
                                                alt="" class="rounded" style="height: 8vh"></li>
                                    </ol>
                                    <h6>Cara Melihat Detail Data Karyawan</h6>
                                    <ol>
                                        <li><span class="me-1">Tekan Tombol Detail </span> <img
                                                src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan6.png') }}"
                                                alt="" class="rounded" style="height: 4vh"><span class="ms-1"> Dibawah
                                                Kolom Aksi untuk karyawan yang dipilih untuk dilihat detail datanya.</span></li>
                                        <li><span class="me-1">Lalu akan muncul modal detail karyawan seperti contoh dibawah
                                                ini.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan6,1.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <h6>Cara Menyunting / Mengedit Data Karyawan</h6>
                                    <ol>
                                        <li><span class="me-1">Tekan Tombol Edit </span> <img
                                                src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan7.png') }}"
                                                alt="" class="rounded" style="height: 4vh"><span class="ms-1"> Dibawah
                                                Kolom Aksi untuk karyawan yang dipilih untuk disunting / diedit datanya.</span>
                                        </li>
                                        <img src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan7,1.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                        <li><span class="me-1">Lalu akan muncul modal edit data karyawan seperti dibawah ini,
                                                edit data karyawan sesuai dengan yang ada pada aturan form tersebut, tidak perlu
                                                menambahkan password jika tidak ingin mengganti password akun dari data karyawan
                                                tersebut.
                                                ini.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan7,1.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                        <li><span class="me-1">Lanjutkan dengan menekan tombol simpan perubahan data pada
                                                bagian bawah modal seperti ditunjukkan pada gambar dibawah ini dan
                                                selesai.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan7,3.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan7,2.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <h6>Cara Menghapus Data Karyawan</h6>
                                    <ol>
                                        <li><span class="me-1">Tekan Tombol Delete </span> <img
                                                src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan8.png') }}"
                                                alt="" class="rounded" style="height: 4vh"><span class="ms-1"> Dibawah
                                                Kolom Aksi untuk karyawan yang dipilih untuk dihapus datanya.</span></li>
                                        <li><span class="me-1">Lalu akan muncul modal peringatan seperti dibawah ini, tekan ya
                                                hapus untuk menghapus dan tekan tombol tidak untuk tidak menghapus.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/datakaryawan/datakaryawan8,1.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                </li>
                                <li class="list-group-item">
                                    <h5>Daftar Absensi</h5>
                                    <h6>Cara Melihat Data Daftar Absensi</h6>
                                    <ol>
                                        <li><span>Tekan tombol daftar absensi di bagian side nav di sebelah kiri atau buka
                                                navigasi di kanan atas pada smartphone</span> <img
                                                src="{{ Vite::asset('resources/assets/guide/daftarabsensi/view_daftarabsensi_button.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka akan tampil halaman untuk melihat semua data daftar absensi
                                                seperti dibawah ini.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/daftarabsensi/view_daftarabsensi.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <h6>Cara Menggenerate Data Absensi</h6>
                                    <ol>
                                        <li><span>Tekan tombol absensi yang ada pada kanan atas</span> <img
                                                src="{{ Vite::asset('resources/assets/guide/daftarabsensi/absensi_button.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Setelah menekan daftar absensi maka akan muncul modal seperti dibawah ini, isi
                                                tanggalnya untuk menggenerate absensi pada tanggal tertentu untuk semua
                                                karyawan. Lalu tekan tombol generate.</span> <img
                                                src="{{ Vite::asset('resources/assets/guide/daftarabsensi/generate_button.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/daftarabsensi/absensi_modal.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <h6>Cara Membuka Web Absensi untuk Absensi Karyawan dengan Cara Login menggunakan Email /
                                        Username dan Password Mereka</h6>
                                    <ol>
                                        <li><span>Tekan tombol absensi yang ada pada kanan atas</span> <img
                                                src="{{ Vite::asset('resources/assets/guide/daftarabsensi/absensi_button.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Setelah menekan daftar absensi maka akan muncul modal seperti dibawah ini,
                                                tidak perlu mengisi tanggal. Lalu tekan tombol ke halaman absensi.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/daftarabsensi/kehalamanabsensi_button.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka akan muncul peringatan seperti dibawah ini apakah ingin
                                                melanjutkan atau tidak, pilih iya dan lanjut ke halaman absensi.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/daftarabsensi/kehalamanabsensi_confirmation.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                        <li><span>Saat pertama kali akan disuruh login dengan password, masukkan password master
                                                aplikasi ini yaitu <b>Master@2233!</b> dan jika berhasil login akan diarahkan ke
                                                halaman absensi karyawan.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/daftarabsensi/view_loginabsensi.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                        <li><span>Jika sudah login maka akan muncul tampilan seperti dibawah ini, ada tempat
                                                untuk karyawan memasukkan email / username dan password mereka untuk melakukan
                                                absensi untuk hari ini dan juga hasilnya bisa dilihat pada tabel absen hari ini
                                                dikanan dari login untuk absen dikirinya seperti gambar dibawah ini. Tekan
                                                tombol catat kehadiran setelah memasukkan kredensial untuk melakukan presensi
                                                hari ini.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/daftarabsensi/view_absensi.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <h6>Cara Ekspor / Download Data Absensi dalam Bentuk PDF</h6>
                                    <ol>
                                        <li><span class="me-1">Tekan tombol unduh PDF yang ada pada pojok kanan sebelah kiri
                                                tombol
                                                absensi pada view utama daftar absensi</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_pdf.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li>Jika muncul dialog untuk unduh file tersebut silahkan diperbolehkan untuk mengunduh
                                            pada direktori yang anda inginkan</li>

                                    </ol>
                                    <h6>Cara Ekspor / Download Data Absensi dalam Bentuk Excel</h6>
                                    <ol>
                                        <li><span class="me-1">Tekan tombol unduh Excel yang ada pada pojok kanan sebelah
                                                kiri tombol
                                                absensi pada view utama daftar absensi</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_excel.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li>Jika muncul dialog untuk unduh file tersebut silahkan diperbolehkan untuk mengunduh
                                            pada direktori yang anda inginkan</li>
                                    </ol>
                                    <h6>Cara Melihat Detail Data Absensi</h6>
                                    <ol>
                                        <li><span class="me-1">Tekan tombol detail daftar absensi pada tabel yang berada
                                                dibawah kolom aksi.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_show.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li>Maka akan muncul seperti view dibawah ini, kita bisa melihat detail absensi pada
                                            modal detail tersebut.</li>
                                        <img src="{{ Vite::asset('resources/assets/guide/daftarabsensi/modal_detailabsensi.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <h6>Cara Menyunting / Mengedit Data Absensi</h6>
                                    <ol>
                                        <li><span class="me-1">Tekan tombol edit daftar absensi pada tabel yang berada
                                                dibawah kolom aksi.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_edit.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li>Maka akan muncul seperti view dibawah ini, kita bisa melihat data absensi pada
                                            modal edit tersebut dan dapat mengeditnya, jika sudah mengedit keterangan dan status
                                            absensi kita bisa klik tombol simpan dan selesai.</li>
                                        <img src="{{ Vite::asset('resources/assets/guide/daftarabsensi/modal_editabsensi.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <h6>Cara Menghapus Data Absensi</h6>
                                    <ol>
                                        <li><span class="me-1">Tekan tombol delete daftar absensi pada tabel yang berada
                                                dibawah kolom aksi.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_delete.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li>Maka akan muncul modal sebagai konfirmasi penghapusan data absensi tersebut, jika
                                            sudah yakin tekan iya jika ingin membatalkan tekan tidak</li>
                                        <img src="{{ Vite::asset('resources/assets/guide/daftarabsensi/modal_confirmdeleteabsensi.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                </li>
                                <li class="list-group-item">
                                    <h5>Persetujuan Cuti</h5>
                                    <h6>Cara Melihat Data Persetujuan Cuti</h6>

                                    <h6>Cara Ekspor / Download Data Persetujuan Cuti dalam Bentuk PDF</h6>
                                    <ol>
                                        <li><span class="me-1">Tekan tombol unduh PDF yang ada pada pojok kanan</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_pdf.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li>Jika muncul dialog untuk unduh file tersebut silahkan diperbolehkan untuk mengunduh
                                            pada direktori yang anda inginkan</li>
                                    </ol>
                                    <h6>Cara Ekspor / Download Data Persetujuan Cuti dalam Bentuk Excel</h6>
                                    <ol>
                                        <li><span class="me-1">Tekan tombol unduh Excel yang ada pada pojok kanan</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_excel.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li>Jika muncul dialog untuk unduh file tersebut silahkan diperbolehkan untuk mengunduh
                                            pada direktori yang anda inginkan</li>
                                    </ol>
                                    <h6>Cara untuk Menyetujui atau Menolak Pengajuan Cuti Karyawan</h6>
                                    <ol>
                                        <li><span class="me-1">Tekan tombol persetujuan cuti pada dibawah kolom aksi
                                                ditabel</span><img
                                                src="{{ Vite::asset('resources/assets/guide/persetujuancuti/tombol_persetujuancuti.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li>Maka akan muncul modal detail cuti dan juga tombol untuk menyetujui maupun menolak
                                            cuti yang diajukan karyawan, jika cuti ditolak maka tekan tombol tolak dan jika
                                            setuju tekan tombol setujui.</li>
                                        <img src="{{ Vite::asset('resources/assets/guide/persetujuancuti/modal_persetujuancuti.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <h6>Cara Menghapus Data Pengajuan Cuti Karyawan</h6>
                                    <ol>
                                        <li><span class="me-1">Tekan tombol hapus data persetujuan cuti yang ada di bawah
                                                kolom aksi
                                                ditabel</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_delete.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li>Selanjutnya akan muncul modal konfirmasi penghapusan data cuti, pilih iya untuk
                                            menghapus dan tidak untuk membatalkan penghapusan.</li>
                                        <img src="{{ Vite::asset('resources/assets/guide/persetujuancuti/modal_confirmdelete.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                </li>
                                <li class="list-group-item">
                                    <h5>Penggajian</h5>
                                    <h6>Cara Melihat Data Penggajian</h6>
                                    <ol>
                                        <li><span class="me-1">Cara melihat data penggajian yaitu dengan cek pada navbar
                                                disebelah kiri atau di smartphone sebelah kanan atas dibuka terlebih dahulu lalu
                                                cari tombol penggajian.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/penggajian/button_viewpenggajian.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah klik tombol maka akan muncul tampilan seperti dibawah ini, kita
                                                bisa melihat data karyawan terlebih dahulu untuk menentukan kita ingin melihat
                                                data gaji untuk karyawan yang mana.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/penggajian/view_penggajian.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                        <li><span class="me-1">Masuk ke salah satu detail data penggajian pada suatu karyawan
                                                dengan menekan tombol detail data karyawan berbentuk dollar </span><img
                                                src="{{ Vite::asset('resources/assets/guide/penggajian/button_detailgajiperkaryawan.png') }}"
                                                alt="" class="rounded" style="height: 4vh"> <span
                                                class="ms-1">sehingga menampilkan detail data penggajian seperti dibawah
                                                ini.</span> </li>
                                        <img src="{{ Vite::asset('resources/assets/guide/penggajian/view_penggajianperkaryawan.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <h6>Cara Untuk Membuat Komponen Gaji</h6>
                                    <ol>
                                        <li><span class="me-1">Klik tombol komponen gaji pada halaman penggajian per karyawan
                                                (masuk ke riwayat penggajian / detail penggajian per karyawan dahulu dari index)
                                                di pojok kanan atas.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/penggajian/button_komponengaji.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah diklik akan muncul modal popup untuk membuat komponen gaji dan bisa
                                                tekan tombol simpan</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/penggajian/view_komponengaji_simpan.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                        <li><span class="me-1">Jika sudah disimpan untuk memastikan komponen gaji tersimpan
                                                maka kembali ke langkah pertama dan cek modal tombol berubah menjadi ubah dan
                                                kolom sudah otomatis terisi data yang sudah diinputkan sebelumnya</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/penggajian/view_komponengaji_ubah.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <h6>Cara Untuk Membuat Data Penggajian</h6>
                                    <ol>
                                        <li><span class="me-1">Klik tombol buat data penggajian (pastikan sudah membuat
                                                komponen gaji terlebih dahulu!) di kanan atas pada halaman detail data
                                                penggajian per karyawan</span><img
                                                src="{{ Vite::asset('resources/assets/guide/penggajian/button_tambahdatagaji.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka akan muncul popup modal untuk membuat sebuah data gaji
                                                karyawan seperti dibawah ini. (pastikan data gaji yang dibuat tidak pada bulan
                                                yang sama pada data gaji yang telah dibuat sebelumnya!)</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/penggajian/view_tambahdatagaji.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                        <li><span class="me-1">Masukkan semua data yang diperlukan, beberapa kolom akan
                                                digenerate secara otomatis seperti kolom gaji pokok, potongan ketidak
                                                hadiran,total potongan, dan total gaji. Sedangkan kita dapat mengubah bulan
                                                gaji, potongan lain, dan total tunjangan.</span></li>
                                        <li>Jika sudah bisa tekan tombol simpan di kanan bawah pojok dan data penggajian akan
                                            tersimpan.</li>
                                    </ol>
                                    <h6>Cara Print PDF Slip Gaji</h6>
                                    <ol>
                                        <li><span class="me-1">Klik tombol print data penggajian di bawah kolom aksi pada
                                                tabel</span><img
                                                src="{{ Vite::asset('resources/assets/guide/penggajian/button_printpdfslipgaji.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka akan membuka halaman baru untuk print slip gaji dalam bentuk
                                                PDF seperti dibawah ini dan file slip gaji siap diunduh.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/penggajian/view_slipgaji.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <h6>Cara Melihat Detail Data Gaji</h6>
                                    <ol>
                                        <li><span class="me-1">Klik tombol show data penggajian di bawah kolom aksi pada
                                                tabel</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_show.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka akan membuka halaman baru untuk melihat detail data gaji
                                                seperti dibawah ini.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/penggajian/view_showgaji.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                        <li><span>Pada pojok kanan bawah pada modal diatas terdapat tombol untuk mengubah status
                                                gaji apakah gaji
                                                kredit atau sudah terbayar, jika sudah terbayar klik terbayar dan karyawan dapat
                                                melihat gajinya serta mencetak slip gaji.</span></li>
                                    </ol>
                                    <h6>Cara Menyunting / Mengedit Data Gaji</h6>
                                    <ol>
                                        <li><span class="me-1">Klik tombol edit data penggajian di bawah kolom aksi pada
                                                tabel</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_edit.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka akan membuka halaman baru untuk melihat detail data gaji
                                                seperti dibawah ini dan dapat mengedit inputan gaji nya, isi data gaji sesuai
                                                dengan aturan form yang ada, sama ketika kita ingin membuat data gaji
                                                baru.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/penggajian/view_editgaji.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                        <li><span>Jika sudah mengedit data dialamnya di kanan bawah pada modal terdapat tombol
                                                sunting diklik, maka otomatis data gaji karyawan akan berubah.</span></li>
                                    </ol>
                                    <h6>Cara Menghapus Data Gaji</h6>
                                    <ol>
                                        <li><span class="me-1">Klik tombol delete data penggajian di bawah kolom aksi pada
                                                tabel</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_delete.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka akan muncul sebuah modal popup konfirmasi delete, tekan iya
                                                jika ingin menghapus data gaji dan tekan tidak untuk membatalkan penghapusan
                                                data gaji.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/penggajian/view_confirmdelete.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <h6>Cara Ekspor / Download Data Gaji dalam Bentuk PDF</h6>
                                    <ol>
                                        <li><span class="me-1">Pergi ke index halaman penggajian (bukan detail penggajian
                                                karyawan) lalu cari tombol unduh pdf pada pojok kanan atas lalu klik tombol
                                                tersebut.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_pdf.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka otomatis file akan terdownload dan bisa disimpan sesuai
                                                keinginan.</span></li>
                                    </ol>
                                    <h6>Cara Ekspor / Download Data Gaji dalam Bentuk Excel</h6>
                                    <ol>
                                        <li><span class="me-1">Pergi ke index halaman penggajian (bukan detail penggajian
                                                karyawan) lalu cari tombol unduh excel pada pojok kanan atas lalu klik tombol
                                                tersebut.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_excel.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka otomatis file akan terdownload dan bisa disimpan sesuai
                                                keinginan.</span></li>
                                    </ol>
                                </li>
                                <li class="list-group-item">
                                    <h5>Rekrutmen</h5>
                                    <h6>Cara Melihat Data Rekrutmen</h6>
                                    <ol>
                                        <li><span class="me-1">Pergi ke navbar lalu cari tombol untuk melihat data
                                                rekrutmen</span><img
                                                src="{{ Vite::asset('resources/assets/guide/rekrutmen/button_datarekrutmen.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka akan muncul tampilan halaman rekrutmen seperti dibawah
                                                ini.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/rekrutmen/view_datarekrutmen.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <h6>Cara Menambahkan Data Rekrutmen</h6>
                                    <ol>
                                        <li><span class="me-1">Klik tombol tambah pada kanan atas di halaman data
                                                rekrutmen.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/rekrutmen/button_tambahdatarekrutmen.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka akan muncul tampilan modal untuk menambah data rekrutmen
                                                seperti dibawah ini, isi formnya sesuai dengan yang diharapkan.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/rekrutmen/view_tambahdatarekrutmen.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                        <li>Jika sudah klik tombol simpan data pada pojok kanan bawah pada modal diatas lalu
                                            otomatis data rekrutmen akan tersimpan.</li>
                                    </ol>
                                    <h6>Cara Mengunduh File PDF dari Data Rekrutmen</h6>
                                    <ol>
                                        <li><span class="me-1">Pergi ke index halaman rekrutmen lalu cari tombol unduh pdf
                                                pada pojok kanan atas lalu klik tombol
                                                tersebut.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_pdf.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka otomatis file akan terdownload dan bisa disimpan sesuai
                                                keinginan.</span></li>
                                    </ol>
                                    <h6>Cara Mengunduh File Excel dari Data Rekrutmen</h6>
                                    <ol>
                                        <li><span class="me-1">Pergi ke index halaman rekrutmen lalu cari tombol unduh excel
                                                pada pojok kanan atas lalu klik tombol
                                                tersebut.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_excel.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka otomatis file akan terdownload dan bisa disimpan sesuai
                                                keinginan.</span></li>
                                    </ol>
                                    <h6>Cara Melihat Detail Data Rekrutmen dan Juga Mengganti Status Rekrutmen</h6>
                                    <ol>
                                        <li><span class="me-1">Klik tombol show data rekrutmen dibawah kolom aksi pada tabel
                                                data.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_show.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka akan muncul tampilan modal yang memperlihatkan detail data
                                                calon karyawan yang akan direkrut dan kita bisa mengganti statusnya apakah
                                                diterima atau ditolak pada pojok kanan bawah modal.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/rekrutmen/view_showdatarekrutmen.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                    <h6>Cara Menyunting / Mengedit Data Rekrutmen</h6>
                                    <ol>
                                        <li><span class="me-1">Klik tombol edit data rekrutmen dibawah kolom aksi pada tabel
                                                data.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_edit.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka akan muncul tampilan modal yang memperlihatkan detail data
                                                calon karyawan seperti dibawah ini yang akan direkrut dan kita bisa mengedit
                                                data - data terkait kandidat calon karyawan baru tersebut seperti nama, alamat,
                                                dan lainnya.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/rekrutmen/view_editdatarekrutmen.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                        <li>Jika sudah mengedit data dan memasukkan data yang diubah kita bisa klik tombol
                                            simpan perubahan data pada pojok kanan bawah untuk menyimpan perubahan data yang
                                            telah kita
                                            inputkan.</li>
                                    </ol>
                                    <h6>Menghapus Data Rekrutmen</h6>
                                    <ol>
                                        <li><span class="me-1">Klik tombol delete data rekrutmen dibawah kolom aksi pada
                                                tabel
                                                data.</span><img
                                                src="{{ Vite::asset('resources/assets/guide/tombol_delete.png') }}"
                                                alt="" class="rounded" style="height: 4vh"></li>
                                        <li><span>Jika sudah maka akan muncul tampilan modal seperti di bawah ini yang
                                                mengkonfirmasi apakah ingin menghapus data rekrutmen atau tidak, klik tombol iya
                                                jika ingin menghapus dan juga klik tidak jika tidak ingin menghapus.</span></li>
                                        <img src="{{ Vite::asset('resources/assets/guide/rekrutmen/view_confirmdelete.png') }}"
                                            alt="" class="rounded" style="height: 25vh">
                                    </ol>
                                </li>
                            </ul>
                        @endif
                    @endauth

                    <h3>Bagian Karyawan</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <h5>Pengajuan Cuti</h5>
                            <h6>Cara Melihat Data Pengajuan Cuti</h6>
                            <ol>
                                <li><span class="me-1">Pergi ke navbar lalu cari tombol untuk melihat data
                                        pengajuan cuti</span><img
                                        src="{{ Vite::asset('resources/assets/guide/pengajuancuti/button_viewpengajuancuti.png') }}"
                                        alt="" class="rounded" style="height: 4vh"></li>
                                <li><span>Jika sudah maka akan muncul tampilan halaman pengajuan cuti seperti dibawah
                                        ini.</span></li>
                                <img src="{{ Vite::asset('resources/assets/guide/pengajuancuti/view_pengajuancuti.png') }}"
                                    alt="" class="rounded" style="height: 25vh">
                            </ol>
                            <h6>Cara Melakukan Pengajuan Cuti</h6>
                            <ol>
                                <li><span class="me-1">Tekan tombol ajukan cuti yang berada pada pojok kanan
                                        atas.</span><img
                                        src="{{ Vite::asset('resources/assets/guide/pengajuancuti/button_ajukancuti.png') }}"
                                        alt="" class="rounded" style="height: 4vh"></li>
                                <li><span>Jika sudah maka akan muncul tampilan modal untuk mengajukan data cuti baru kepada
                                        admin. Isi tanggal mulai, tanggal akhir, dan alasan mengambil cuti didalam modal
                                        tersebut.</span></li>
                                <img src="{{ Vite::asset('resources/assets/guide/pengajuancuti/view_ajukancuti.png') }}"
                                    alt="" class="rounded" style="height: 25vh">
                                <li>Jika sudah mengisikan data pada modal diatas kita bisa klik tombol ajukan dan otomatis
                                    cuti akan diajukan, tunggu hingga cuti diapprove oleh admin akan diberitahu melalui
                                    notifikasi sistem.</li>
                            </ol>
                            <h6>Cara Melihat Detail Data Pengajuan Cuti</h6>
                            <ol>
                                <li><span class="me-1">Tekan tombol detail pengajuan cuti yang berada di bawah kolom aksi
                                        dengan ikon mata.</span><img
                                        src="{{ Vite::asset('resources/assets/guide/pengajuancuti/button_detailcuti.png') }}"
                                        alt="" class="rounded" style="height: 4vh"></li>
                                <li><span>Jika sudah maka akan muncul tampilan modal yang menunjukkan detail data cuti yang
                                        telah kita ajukan seperti dibawah ini.</span></li>
                                <img src="{{ Vite::asset('resources/assets/guide/pengajuancuti/view_detailcuti.png') }}"
                                    alt="" class="rounded" style="height: 25vh">
                            </ol>
                        </li>
                        <li class="list-group-item">
                            <h5>Riwayat Gaji</h5>
                            <h6>Cara Melihat Data Riwayat Gaji</h6>
                            <ol>
                                <li><span class="me-1">Pergi ke navbar lalu cari tombol untuk melihat data
                                        riwayat gaji</span><img
                                        src="{{ Vite::asset('resources/assets/guide/riwayatgaji/button_viewriwayatgaji.png') }}"
                                        alt="" class="rounded" style="height: 4vh"></li>
                                <li><span>Jika sudah maka akan muncul tampilan halaman riwayat gaji seperti dibawah
                                        ini.</span></li>
                                <img src="{{ Vite::asset('resources/assets/guide/riwayatgaji/view_riwayatgaji.png') }}"
                                    alt="" class="rounded" style="height: 25vh">
                            </ol>
                            <h6>Cara Mengunduh / Print PDF Slip Gaji</h6>
                            <ol>
                                <li><span class="me-1">Klik tombol print pdf slip gaji dibawah kolom aksi pada tabel data
                                        riwayat gaji</span><img
                                        src="{{ Vite::asset('resources/assets/guide/riwayatgaji/button_printpdfslipgaji.png') }}"
                                        alt="" class="rounded" style="height: 4vh"></li>
                                <li><span>Jika sudah maka akan membuka jendela halaman baru pada browser untuk print PDF
                                        slip gaji yang dipilih seperti dibawah ini.</span></li>
                                <img src="{{ Vite::asset('resources/assets/guide/riwayatgaji/view_printpdfslipgaji.png') }}"
                                    alt="" class="rounded" style="height: 25vh">
                            </ol>
                        </li>
                        <li class="list-group-item">
                            <h5>Riwayat Absensi</h5>
                            <h6>Cara Melihat Data Riwayat Absensi</h6>
                            <ol>
                                <li><span class="me-1">Pergi ke navbar lalu cari tombol untuk melihat data
                                        riwayat absensi</span><img
                                        src="{{ Vite::asset('resources/assets/guide/riwayatabsensi/button_viewriwayatabsensi.png') }}"
                                        alt="" class="rounded" style="height: 4vh"></li>
                                <li><span>Jika sudah maka akan muncul tampilan halaman riwayat absensi seperti dibawah
                                        ini.</span></li>
                                <img src="{{ Vite::asset('resources/assets/guide/riwayatabsensi/view_riwayatabsensi.png') }}"
                                    alt="" class="rounded" style="height: 25vh">
                            </ol>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
