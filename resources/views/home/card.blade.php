        <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Citas</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $cardcitas }}</span>
                    </div>
                    <a href="{{ url('/miscitas') }}">
                      <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="ni ni-time-alarm"></i>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Pacientes</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $cardpaciente }}</span>
                    </div>
                      <a href="{{ url('/paciente') }}">
                        <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                      </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Enfermera</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $cardenfermera }}</span>
                    </div>
                    <a href="{{ url('/enfermera') }}">
                      <div class="col-auto">
                      <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Especialidades</h5>
                      <span class="h2 font-weight-bold mb-0">{{ $cardespecialidad }}</span>
                    </div>
                    <a href="{{ url('/specialties') }}">
                      <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="ni ni-send"></i>
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
