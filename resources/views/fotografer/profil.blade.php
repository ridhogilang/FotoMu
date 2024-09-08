@extends('layout.foto')

@push('header')
<style>
    .photo-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 10px;
}

.photo-gallery img {
    width: 100%;
    height: auto;
    border-radius: 5px;
}

</style>
@endpush

@section('main')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Contacts</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Profile</h4>
                    </div>
                </div>
            </div>
            <!-- end page title --> <!-- end page title -->

            <div class="row">
                <div class="col-lg-4 col-xl-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="{{ asset('images/users/user-1.jpg') }}" class="rounded-circle avatar-lg img-thumbnail"
                                alt="profile-image">

                            <h4 class="mb-0">Geneva McKnight</h4>
                            <p class="text-muted">@fotografer</p>

                            <a href="" class="btn btn-light btn-xs waves-effect mb-2 waves-light">Sunting</a>
                            <a href="{{ route('foto.upload') }}" class="btn btn-blue btn-xs waves-effect mb-2 waves-light">Unggah</a>

                            <div class="text-start mt-3">
                                <h4 class="font-13 text-uppercase">About Me :</h4>
                                <p class="text-muted font-13 mb-3">
                                    Hi I'm Johnathn Deo,has been the industry's standard dummy text ever since
                                    the 1500s, when an unknown printer took a galley of type.
                                </p>
                                <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ms-2">Geneva
                                        D. McKnight</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ms-2">(123) 123
                                        1234</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span
                                        class="ms-2">user@email.domain</span></p>

                                <p class="text-muted mb-1 font-13"><strong>Location :</strong> <span
                                        class="ms-2">USA</span></p>
                            </div>

                            <ul class="social-list list-inline mt-3 mb-0">
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
                                            class="mdi mdi-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                            class="mdi mdi-google"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                            class="mdi mdi-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);"
                                        class="social-list-item border-secondary text-secondary"><i
                                            class="mdi mdi-github"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div> <!-- end card -->

                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Inbox</h4>

                            <div class="inbox-widget" data-simplebar style="max-height: 350px;">
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets/images/users/user-2.jpg"
                                            class="rounded-circle" alt=""></div>
                                    <p class="inbox-item-author">Tomaslau</p>
                                    <p class="inbox-item-text">I've finished it! See you so...</p>
                                    <p class="inbox-item-date">
                                        <a href="javascript:(0);" class="btn btn-sm btn-link text-info font-13"> Reply </a>
                                    </p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets/images/users/user-3.jpg"
                                            class="rounded-circle" alt=""></div>
                                    <p class="inbox-item-author">Stillnotdavid</p>
                                    <p class="inbox-item-text">This theme is awesome!</p>
                                    <p class="inbox-item-date">
                                        <a href="javascript:(0);" class="btn btn-sm btn-link text-info font-13"> Reply </a>
                                    </p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets/images/users/user-4.jpg"
                                            class="rounded-circle" alt=""></div>
                                    <p class="inbox-item-author">Kurafire</p>
                                    <p class="inbox-item-text">Nice to meet you</p>
                                    <p class="inbox-item-date">
                                        <a href="javascript:(0);" class="btn btn-sm btn-link text-info font-13"> Reply </a>
                                    </p>
                                </div>

                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets/images/users/user-5.jpg"
                                            class="rounded-circle" alt=""></div>
                                    <p class="inbox-item-author">Shahedk</p>
                                    <p class="inbox-item-text">Hey! there I'm available...</p>
                                    <p class="inbox-item-date">
                                        <a href="javascript:(0);" class="btn btn-sm btn-link text-info font-13"> Reply </a>
                                    </p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets/images/users/user-6.jpg"
                                            class="rounded-circle" alt=""></div>
                                    <p class="inbox-item-author">Adhamdannaway</p>
                                    <p class="inbox-item-text">This theme is awesome!</p>
                                    <p class="inbox-item-date">
                                        <a href="javascript:(0);" class="btn btn-sm btn-link text-info font-13"> Reply
                                        </a>
                                    </p>
                                </div>

                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets/images/users/user-3.jpg"
                                            class="rounded-circle" alt=""></div>
                                    <p class="inbox-item-author">Stillnotdavid</p>
                                    <p class="inbox-item-text">This theme is awesome!</p>
                                    <p class="inbox-item-date">
                                        <a href="javascript:(0);" class="btn btn-sm btn-link text-info font-13"> Reply
                                        </a>
                                    </p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets/images/users/user-4.jpg"
                                            class="rounded-circle" alt=""></div>
                                    <p class="inbox-item-author">Kurafire</p>
                                    <p class="inbox-item-text">Nice to meet you</p>
                                    <p class="inbox-item-date">
                                        <a href="javascript:(0);" class="btn btn-sm btn-link text-info font-13"> Reply
                                        </a>
                                    </p>
                                </div>
                            </div> <!-- end inbox-widget -->
                        </div>
                    </div> <!-- end card-->

                </div> <!-- end col-->

                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill navtab-bg">
                                <li class="nav-item">
                                    <a href="#aboutme" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                        About Me
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#timeline" data-bs-toggle="tab" aria-expanded="false"
                                        class="nav-link">
                                        Timeline
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#settings" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        Settings
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="aboutme">

                                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-briefcase me-1"></i>
                                        Foto Unggahanmu</h5>

                                        <div class="photo-gallery">
                                            @foreach ($foto->take(10) as $fotoItem)  <!-- Membatasi hanya 10 foto -->
                                                <img src="{{ Storage::url($fotoItem->foto) }}" alt="Image {{ $loop->index + 1 }}">
                                            @endforeach
                                        </div>
                                        
                                        @if($foto->count() > 10)
                                            <div class="text-center mt-3">
                                                <a href="{{ route('foto.filemanager') }}" class="btn btn-primary">Lihat Selengkapnya</a> <!-- Tombol Lihat Selengkapnya -->
                                            </div>
                                        @endif                              

                                    <h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-cards-variant me-1"></i>
                                        Projects</h5>
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Project Name</th>
                                                    <th>Start Date</th>
                                                    <th>Due Date</th>
                                                    <th>Status</th>
                                                    <th>Clients</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>App design and development</td>
                                                    <td>01/01/2015</td>
                                                    <td>10/15/2018</td>
                                                    <td><span class="badge bg-info">Work in Progress</span>
                                                    </td>
                                                    <td>Halette Boivin</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Coffee detail page - Main Page</td>
                                                    <td>21/07/2016</td>
                                                    <td>12/05/2018</td>
                                                    <td><span class="badge bg-success">Pending</span></td>
                                                    <td>Durandana Jolicoeur</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Poster illustation design</td>
                                                    <td>18/03/2018</td>
                                                    <td>28/09/2018</td>
                                                    <td><span class="badge bg-pink">Done</span></td>
                                                    <td>Lucas Sabourin</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Drinking bottle graphics</td>
                                                    <td>02/10/2017</td>
                                                    <td>07/05/2018</td>
                                                    <td><span class="badge bg-blue">Work in Progress</span>
                                                    </td>
                                                    <td>Donatien Brunelle</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Landing page design - Home</td>
                                                    <td>17/01/2017</td>
                                                    <td>25/05/2021</td>
                                                    <td><span class="badge bg-warning">Coming soon</span></td>
                                                    <td>Karel Auberjo</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                </div> 

                                <div class="tab-pane" id="timeline">

                                    <!-- comment box -->
                                    <form action="#" class="comment-area-box mt-2 mb-3">
                                        <span class="input-icon">
                                            <textarea rows="3" class="form-control" placeholder="Write something..."></textarea>
                                        </span>
                                        <div class="comment-area-btn">
                                            <div class="float-end">
                                                <button type="submit"
                                                    class="btn btn-sm btn-dark waves-effect waves-light">Post</button>
                                            </div>
                                            <div>
                                                <a href="#" class="btn btn-sm btn-light"><i
                                                        class="far fa-user"></i></a>
                                                <a href="#" class="btn btn-sm btn-light"><i
                                                        class="fa fa-map-marker-alt"></i></a>
                                                <a href="#" class="btn btn-sm btn-light"><i
                                                        class="fa fa-camera"></i></a>
                                                <a href="#" class="btn btn-sm btn-light"><i
                                                        class="far fa-smile"></i></a>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- end comment box -->

                                    <!-- Story Box-->
                                    <div class="border border-light p-2 mb-3">
                                        <div class="d-flex align-items-start">
                                            <img class="me-2 avatar-sm rounded-circle"
                                                src="assets/images/users/user-3.jpg" alt="Generic placeholder image">
                                            <div class="w-100">
                                                <h5 class="m-0">Jeremy Tomlinson</h5>
                                                <p class="text-muted"><small>about 2 minuts ago</small></p>
                                            </div>
                                        </div>
                                        <p>Story based around the idea of time lapse, animation to post soon!
                                        </p>

                                        <img src="assets/images/small/img-1.jpg" alt="post-img" class="rounded me-1"
                                            height="60" />
                                        <img src="assets/images/small/img-2.jpg" alt="post-img" class="rounded me-1"
                                            height="60" />
                                        <img src="assets/images/small/img-3.jpg" alt="post-img" class="rounded"
                                            height="60" />

                                        <div class="mt-2">
                                            <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                                    class="mdi mdi-reply"></i> Reply</a>
                                            <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                                    class="mdi mdi-heart-outline"></i> Like</a>
                                            <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                                    class="mdi mdi-share-variant"></i> Share</a>
                                        </div>
                                    </div>

                                    <!-- Story Box-->
                                    <div class="border border-light p-2 mb-3">
                                        <div class="d-flex align-items-start">
                                            <img class="me-2 avatar-sm rounded-circle"
                                                src="assets/images/users/user-4.jpg" alt="Generic placeholder image">
                                            <div class="w-100">
                                                <h5 class="m-0">Thelma Fridley</h5>
                                                <p class="text-muted"><small>about 1 hour ago</small></p>
                                            </div>
                                        </div>
                                        <div class="font-16 text-center fst-italic text-dark">
                                            <i class="mdi mdi-format-quote-open font-20"></i> Cras sit amet
                                            nibh libero, in
                                            gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras
                                            purus odio, vestibulum in vulputate at, tempus viverra turpis. Duis
                                            sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper
                                            porta. Mauris massa.
                                        </div>

                                        <div class="post-user-comment-box">
                                            <div class="d-flex align-items-start">
                                                <img class="me-2 avatar-sm rounded-circle"
                                                    src="assets/images/users/user-3.jpg" alt="Generic placeholder image">
                                                <div class="w-100">
                                                    <h5 class="mt-0">Jeremy Tomlinson <small class="text-muted">3 hours
                                                            ago</small></h5>
                                                    Nice work, makes me think of The Money Pit.

                                                    <br />
                                                    <a href="javascript: void(0);"
                                                        class="text-muted font-13 d-inline-block mt-2"><i
                                                            class="mdi mdi-reply"></i> Reply</a>

                                                    <div class="d-flex align-items-start mt-3">
                                                        <a class="pe-2" href="#">
                                                            <img src="assets/images/users/user-4.jpg"
                                                                class="avatar-sm rounded-circle"
                                                                alt="Generic placeholder image">
                                                        </a>
                                                        <div class="w-100">
                                                            <h5 class="mt-0">Kathleen Thomas <small class="text-muted">5
                                                                    hours ago</small>
                                                            </h5>
                                                            i'm in the middle of a timelapse animation myself!
                                                            (Very different though.) Awesome stuff.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-start mt-2">
                                                <a class="pe-2" href="#">
                                                    <img src="assets/images/users/user-1.jpg" class="rounded-circle"
                                                        alt="Generic placeholder image" height="31">
                                                </a>
                                                <div class="w-100">
                                                    <input type="text" id="simpleinput"
                                                        class="form-control border-0 form-control-sm"
                                                        placeholder="Add comment">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-2">
                                            <a href="javascript: void(0);" class="btn btn-sm btn-link text-danger"><i
                                                    class="mdi mdi-heart"></i> Like (28)</a>
                                            <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                                    class="mdi mdi-share-variant"></i> Share</a>
                                        </div>
                                    </div>

                                    <!-- Story Box-->
                                    <div class="border border-light p-2 mb-3">
                                        <div class="d-flex align-items-start">
                                            <img class="me-2 avatar-sm rounded-circle"
                                                src="assets/images/users/user-6.jpg" alt="Generic placeholder image">
                                            <div class="w-100">
                                                <h5 class="m-0">Jeremy Tomlinson</h5>
                                                <p class="text-muted"><small>15 hours ago</small></p>
                                            </div>
                                        </div>
                                        <p>The parallax is a little odd but O.o that house build is awesome!!
                                        </p>

                                        <iframe src='https://player.vimeo.com/video/87993762' height='300'
                                            class="img-fluid border-0"></iframe>
                                    </div>

                                    <div class="text-center">
                                        <a href="javascript:void(0);" class="text-danger"><i
                                                class="mdi mdi-spin mdi-loading me-1"></i> Load more </a>
                                    </div>

                                </div>
                                <!-- end timeline content-->

                                <div class="tab-pane" id="settings">
                                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i>
                                            Personal Info</h5>
                                            <form action="">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="firstname" class="form-label">Nama</label>
                                                            <input type="text" class="form-control" id="firstname"
                                                                value="{{ $getUser->name }}" placeholder="Enter first name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="lastname" class="form-label">No. Whatsapp</label>
                                                            <input type="number" class="form-control" id="lastname"
                                                                value="{{ $getUser->nowa }}" placeholder="Enter last name">
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
        
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="useremail" class="form-label">Email
                                                                Address</label>
                                                            <input type="email" class="form-control" id="useremail"
                                                                placeholder="Enter email" value="{{ $getUser->email }}" disabled>
                                                            <span class="form-text text-muted"><small>If you want to
                                                                    change email please <a href="javascript: void(0);">click</a>
                                                                    here.</small></span>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="text-end">
                                                    <button type="submit"
                                                        class="btn btn-success waves-effect waves-light mb-2"><i
                                                            class="mdi mdi-content-save"></i> Update Data</button>
                                                </div>
                                            </form>
                                        <h5 class="mb-3 text-uppercase bg-light p-2"><i
                                                class="mdi mdi-office-building me-1"></i> Keamanan</h5>
                                                <form method="POST" action="{{ route('user.pass-update') }}">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="old_password" class="form-label">Password Lama</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input type="password" id="old_password" name="old_password"
                                                                        class="form-control" placeholder="Enter your old password"
                                                                        required>
                                                                    <div class="input-group-text"
                                                                        onclick="togglePassword('old_password')">
                                                                        <span class="password-eye"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
            
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="new_password" class="form-label">Password Baru</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input type="password" id="new_password" name="new_password"
                                                                        class="form-control" placeholder="Enter your new password"
                                                                        required>
                                                                    <div class="input-group-text"
                                                                        onclick="togglePassword('new_password')">
                                                                        <span class="password-eye"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="password_confirmation" class="form-label">Konfirmasi
                                                                    Password</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input type="password" id="password_confirmation"
                                                                        name="new_password_confirmation" class="form-control"
                                                                        placeholder="Confirm your password" required
                                                                        oninput="validatePasswords()">
                                                                    <div class="input-group-text"
                                                                        onclick="togglePassword('password_confirmation')">
                                                                        <span class="password-eye"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
            
                                                    <div class="text-end">
                                                        <button type="submit"
                                                            class="btn btn-success waves-effect waves-light mb-2"><i
                                                                class="mdi mdi-content-save"></i> Update Password</button>
                                                    </div>
                                                </form>

                                        <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i>
                                            Fotografer Info</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="social-fb" class="form-label">Facebook</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="fab fa-facebook-square"></i></span>
                                                        <input type="text" class="form-control" id="social-fb"
                                                            placeholder="Url">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="social-tw" class="form-label">Twitter</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="fab fa-twitter"></i></span>
                                                        <input type="text" class="form-control" id="social-tw"
                                                            placeholder="Username">
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="social-insta" class="form-label">Instagram</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="fab fa-instagram"></i></span>
                                                        <input type="text" class="form-control" id="social-insta"
                                                            placeholder="Url">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="social-lin" class="form-label">Linkedin</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="fab fa-linkedin"></i></span>
                                                        <input type="text" class="form-control" id="social-lin"
                                                            placeholder="Url">
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="social-sky" class="form-label">Skype</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fab fa-skype"></i></span>
                                                        <input type="text" class="form-control" id="social-sky"
                                                            placeholder="@username">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="social-gh" class="form-label">Github</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="fab fa-github"></i></span>
                                                        <input type="text" class="form-control" id="social-gh"
                                                            placeholder="Username">
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="text-end">
                                            <button type="submit"
                                                class="btn btn-success waves-effect waves-light mt-2"><i
                                                    class="mdi mdi-content-save"></i> Update</button>
                                        </div>
                                </div>
                                <!-- end settings content-->

                            </div> <!-- end tab-content -->
                        </div>
                    </div> <!-- end card-->

                </div> <!-- end col -->
            </div>
            <!-- end row-->

        </div> <!-- container -->

    </div>
@endsection

@push('footer')
<script>
    function togglePassword(id) {
        const passwordField = document.getElementById(id);
        const passwordEye = passwordField.nextElementSibling.querySelector('.password-eye');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            passwordEye.parentElement.classList.add('show-password');
        } else {
            passwordField.type = 'password';
            passwordEye.parentElement.classList.remove('show-password');
        }
    }

    function validatePasswords() {
        const password = document.getElementById('new_password');
        const confirmPassword = document.getElementById('password_confirmation');

        if (confirmPassword.value === '') {
            confirmPassword.style.borderColor = '';
            return;
        }

        if (password.value !== confirmPassword.value) {
            confirmPassword.style.borderColor = 'red';
        } else {
            confirmPassword.style.borderColor = 'green';
        }
    }
</script>
@endpush
