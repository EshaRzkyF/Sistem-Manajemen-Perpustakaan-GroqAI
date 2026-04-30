# Postman Documentation

Collection ini disiapkan untuk impor langsung ke Postman.

File yang tersedia:

- [Library-Management-API.postman_collection.json](Library-Management-API.postman_collection.json)
- [Library-Management-Local.postman_environment.json](Library-Management-Local.postman_environment.json)

## Cara Import

1. Buka Postman.
2. Klik `Import`.
3. Pilih file collection dan environment di atas.
4. Aktifkan environment `Library Management Local`.
5. Pastikan `base_url` sesuai dengan alamat Laravel Anda.

## Data Saat Ini Di Sistem

### Buku

| Judul | Penulis | Tahun | Stok |
|---|---|---:|---:|
| Sang Pemimpi | Andrea Hirata | 2006 | 40 |
| Ayat-Ayat Cinta | Habiburrahman El Shirazy | 2004 | 3 |
| Perahu Kertas | Dee Lestari | 2009 | 8 |
| Dilan: Dia adalah Dilanku Tahun 1990 | Pidi Baiq | 2014 | 29 |
| Negeri 5 Menara | Ahmad Fuadi | 2009 | 2 |
| Bumi manusia | Pramoedya Ananta Toer | 1980 | 12 |
| Laskar Pelangi | Andrea Hirata | 2005 | 4 |

### Peminjaman

| Nama Peminjam | Judul Buku | Tanggal Pinjam | Tanggal Kembali |
|---|---|---|---|
| Fakhri Irsadi | Sang Pemimpi | 02 Apr 2026 | 30 Apr 2026 |
| Rachman Hidayat | Dilan: Dia adalah Dilanku Tahun 1990 | 09 Apr 2026 | 13 May 2026 |
| Andi Dwi Reza | Negeri 5 Menara | 29 Apr 2026 | 21 May 2026 |
| Anggi Dwi Saputra | Laskar Pelangi | 28 Apr 2026 | 06 Jun 2026 |
| Esha Rizky Filliansyah | Ayat-Ayat Cinta | 30 Apr 2026 | 01 May 2026 |

## Catatan JSON Response

Contoh response di collection memakai data di atas supaya tidak generik. Jika data di database berubah, hasil response Postman juga akan ikut berubah.

## Endpoint Utama

- `GET /api/books`
- `POST /api/books`
- `GET /api/books/{id}`
- `PUT /api/books/{id}`
- `DELETE /api/books/{id}`
- `GET /api/loans`
- `POST /api/loans`
- `DELETE /api/loans/{id}`
- `POST /api/ai/recommendation`
