<footer class="content-footer footer bg-footer-theme" style="margin-top:20px">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-start ">
                  <div class="text-body">
                    <h5>{{ App\Models\Setting::where('key','footer')->first()->value }}</h5>
                  </div>

                </div>
              </div>
            </footer>
