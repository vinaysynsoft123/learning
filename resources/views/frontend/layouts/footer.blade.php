 <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <h6 class="fw-bold">About Trip Rega</h6>
            <p>
              tyutyu 
            </p>
          </div>
          <div class="col-md-4">
            <h6 class="fw-bold">Quick Links</h6>
            <ul class="list-unstyled">
              <li><a href="#">About Us</a></li>
              <li><a href="#">Destinations</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <h6 class="fw-bold">Contact</h6>
            <p>Phone: +<br />Email: </p>
          </div>
        </div>
        <hr />
        <p class="text-center mb-0">
          © laravel. All rights reserved.
        </p>
      </div>
    </footer>
 
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      let roomCount = 1;

      function addRoom() {
        roomCount++;
        const container = document.getElementById("rooms-container");

        const newRoom = document.createElement("div");
        newRoom.className = "room-box";
        newRoom.innerHTML = `
                <button type="button" class="remove-btn" onclick="removeRoom(this)">
                    <i class="fas fa-times"></i>
                </button>
                <div class="room-title">Room ${roomCount}</div>
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <label class="form-label small">Adults</label>
                        <select class="form-select" name="rooms[${
                          roomCount - 1
                        }][adults]">
                            <option>1</option>
                            <option selected>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label small">Child (with bed)</label>
                        <select class="form-select" name="rooms[${
                          roomCount - 1
                        }][child_with_bed]">
                            <option selected>0</option>
                            <option>1</option>
                            <option>2</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label small">Child (no bed)</label>
                        <select class="form-select" name="rooms[${
                          roomCount - 1
                        }][child_no_bed]">
                            <option selected>0</option>
                            <option>1</option>
                            <option>2</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label small">Infant</label>
                        <select class="form-select" name="rooms[${
                          roomCount - 1
                        }][infant]">
                            <option selected>0</option>
                            <option>1</option>
                            <option>2</option>
                        </select>
                    </div>
                </div>
            `;

        container.appendChild(newRoom);

        document
          .querySelectorAll(".remove-btn")
          .forEach((btn) => (btn.style.display = "block"));
      }

      function removeRoom(btn) {
        if (roomCount === 1) return;
        btn.parentElement.remove();
        roomCount--;

        document.querySelectorAll(".room-title").forEach((title, i) => {
          title.textContent = `Room ${i + 1}`;
        });

        if (roomCount === 1) {
          document.querySelector(".remove-btn").style.display = "none";
        }
      }
    </script>
  </body>
</html>
