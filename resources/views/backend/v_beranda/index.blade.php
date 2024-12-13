@extends('backend.v_layouts.app')
@section('content')
<!-- contentAwal -->

<div>
  <h1><marquee behavior="" direction="" widht="100%" bgcolor="white">halo semua</marquee></h1>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body border-top">
            <h5 class="card-title"> {{$judul}}</h5>
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading"> Selamat Datang, {{ Auth::user()->nama}}</h4>
                Di Dashboard Admin Rental Mobil dengan hak akses yang anda miliki sebagai
                <b>
                    @if (Auth::user()->role ==1)
                    Super Admin
                    @elseif(Auth::user()->role ==0)
                    Admin
                    @endif
                </b>
                ini adalah halaman utama dari Dashboard Admin Rental Mobil.
                <hr>
                <p class="mb-0">"Setiap perjalanan pelanggan adalah kepercayaan yang kami jaga. Mari melayani dengan sepenuh hati, karena kepuasan mereka adalah kesuksesan kita!"</p>
            </div>
        </div>
    </div>
</div>
</div>


{{-- <div class="calendar">
  <div class="calendar-header" id="calendar-header"></div>
  <div class="calendar-days">
      <div>Sun</div>
      <div>Mon</div>
      <div>Tue</div>
      <div>Wed</div>
      <div>Thu</div>
      <div>Fri</div>
      <div>Sat</div>
  </div>
  <div class="calendar-dates" id="calendar-dates"></div>
</div> --}}

<div class="d-flex flex-row mb-4">
    <div class="container-fluid">
      <div class="row">
            <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
        <div class="card card-hover">
          <div class="box bg-cyan text-center">
            <h1 class="font-light text-white">
              <i class="mdi mdi-account"></i>
            </h1>
            <h6 class="text-white">User</h6>
          </div>
        </div>
      </div>
    
      <!-- Column -->
      <div class="col-md-6 col-lg-2 col-xlg-3">
        <div class="card card-hover">
          <div class="box bg-warning text-center">
            <h1 class="font-light text-white">
              <i class="bi bi-tags-fill"></i>
            </h1>
            <h6 class="text-white">Data Merk Mobil</h6>
          </div>
        </div>
      </div>
      <!-- Column -->
      <div class="col-md-6 col-lg-2 col-xlg-3">
        <div class="card card-hover">
          <div class="box bg-danger text-center">
            <h1 class="font-light text-white">
              <i class="bi bi-car-front-fill"></i>
            </h1>
            <h6 class="text-white">Data Jenis Mobil</h6>
          </div>
        </div>
      </div>
      <!-- Column -->
      <div class="col-md-6 col-lg-2 col-xlg-3">
        <div class="card card-hover">
          <div class="box bg-info text-center">
            <h1 class="font-light text-white">
              <i class="bi bi-people-fill"></i>
            </h1>
            <h6 class="text-white">Data Nama Penyewa</h6>
          </div>
        </div>
      </div>
    </div>
    </div>
</div>


{{-- <script>
    const calendarHeader = document.getElementById("calendar-header");
    const calendarDates = document.getElementById("calendar-dates");

    const today = new Date();
    const currentMonth = today.getMonth();
    const currentYear = today.getFullYear();
    const currentDate = today.getDate();

    const monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    function generateCalendar(month, year) {
        calendarHeader.textContent = `${monthNames[month]} ${year}`;
        calendarDates.innerHTML = "";

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            calendarDates.innerHTML += `<div></div>`;
        }

        for (let i = 1; i <= daysInMonth; i++) {
            if (i === currentDate && month === currentMonth && year === currentYear) {
                calendarDates.innerHTML += `<div class="today">${i}</div>`;
            } else {
                calendarDates.innerHTML += `<div>${i}</div>`;
            }
        }
    }

    generateCalendar(currentMonth, currentYear);
</script> --}}
    <!-- contentAkhir -->
    @endsection