<?php
$role = $_SESSION['role'] ?? '';
?>

<!DOCTYPE html>
<html>

<head>
  <title>V</title>

  <!-- <link rel="stylesheet" href="View/projects/events.css"> -->
  <link rel="stylesheet" type="text/css" href="/V/View/projects/events.css">
  <?php include __DIR__ . '/../navbar/navbar.php'; ?>
</head>

<body>
  <!-- <1?php include '../navbar/navbar.php'?> -->

  <main>

    <section class="intro">
      <h1>Volunteering Programs</h1>
      <p>Join our community of volunteers making a difference through environmental action</p>
    </section>

    <section class="card-grid">
      <!-- Card 1 -->
      <a href="/V/router.php?module=projects&action=events&event_type=Beach Cleanup#events-section" class="card-link">
        <div class="card">

          <h2>Beach Cleanup</h2>
          <p>Join us in protecting marine ecosystems by removing plastic waste and debris from coastal areas. Every
            piece
            of trash removed helps preserve ocean life.</p>

          <div class="badge-preview">
            <div class="badge-preview-title">Earn this badge:</div>
            <div class="badge-container">
              <div class="badge-icon"><img src="/V/View/projects/E_images/badges/beachcleanup.png"
                  alt="Beach Cleanup" />
              </div>
              <div class="badge-info">
                <h4>Wave Saver</h4>
                <p>Complete your participation for <b>40 Beach Cleanup</b> projects</p>
              </div>
            </div>
          </div>
          <div class="main-card-footer">
            <span>24 Events</span>
            <!-- <button>→</button> -->
          </div>
        </div>
      </a>

      <!-- Card 2 -->
      <a href="/V/router.php?module=projects&action=events&event_type=Mangrove Restoration#events-section"
        class="card-link">
        <div class="card">

          <h2>Mangrove Restoration</h2>
          <p>Help restore vital mangrove forests<br> that protect coastlines from erosion <br>and provide crucial
            habitats for
            marine wildlife.</p>
          <div class="badge-preview">
            <div class="badge-preview-title">Earn this badge:</div>
            <div class="badge-container">
              <div class="badge-icon"><img class="mangrove"
                  src="/V/View/projects/E_images/badges/mangroverestoration.png" alt="Mangrove Restoration" />
              </div>
              <div class="badge-info">
                <h4>Mangrove Starter</h4>
                <p>Complete your participation for <b>20 Mangrove Restoration</b> projects</p>
              </div>
            </div>
          </div>
          <div class="main-card-footer">
            <span>18 Events</span>
            <!-- <button>→</button> -->
          </div>
        </div>
      </a>

      <!-- Card 3 -->
      <a href="/V/router.php?module=projects&action=events&event_type=Tree Planting#events-section" class="card-link">
        <div class="card">
          <!-- <div class="icon">🌳</div> -->
          <h2>Tree Planting</h2>
          <p>Combat climate change by planting native trees in deforested areas. Each tree planted contributes to carbon
            sequestration and biodiversity.</p>
          <div class="badge-preview">
            <div class="badge-preview-title">Earn this badge:</div>
            <div class="badge-container">
              <div class="badge-icon"><img src="/V/View/projects/E_images/badges/treeplanting.png"
                  alt="Tree Planting" />
              </div>
              <div class="badge-info">
                <h4>Forest Builder</h4>
                <p>Complete your participation for <b>35 Tree Planting</b> <br> projects</p>
              </div>
            </div>
          </div>
          <div class="main-card-footer">
            <span>32 Events</span>
            <!-- <button>→</button> -->
          </div>
        </div>
      </a>

      <!-- Card 4 -->
      <a href="/V/router.php?module=projects&action=events&event_type=City Cleanup#events-section" class="card-link">
        <div class="card">

          <h2>City Cleanup</h2>
          <p>Transform urban spaces by removing litter, graffiti, and creating cleaner, more livable communities for
            everyone.</p>
          <div class="badge-preview">
            <div class="badge-preview-title">Earn this badge:</div>
            <div class="badge-container">
              <div class="badge-icon"><img class="city" src="/V/View/projects/E_images/badges/citycleanup.png"
                  alt="City Cleanup" />
              </div>
              <div class="badge-info">
                <h4>Urban Protector</h4>
                <p>Complete your participation for <b>50 City Cleanup</b> <br> projects</p>
              </div>
            </div>
          </div>
          <div class="main-card-footer">
            <span>28 Events</span>
            <!-- <button>→</button> -->
          </div>
        </div>
      </a>

      <!-- Card 5 -->
      <a href="/V/router.php?module=projects&action=events&event_type=Mountain Cleanup#events-section"
        class="card-link">
        <div class="card">

          <h2>Mountain Cleanup</h2>
          <p>Preserve pristine mountain environments by removing waste left by hikers and maintaining trail
            sustainability.</p>
          <div class="badge-preview">
            <div class="badge-preview-title">Earn this badge:</div>
            <div class="badge-container">
              <div class="badge-icon"><img src="/V/View/projects/E_images/badges/mountatincleanup.png"
                  alt="Mountain Cleanup" />
              </div>
              <div class="badge-info">
                <h4>Mountain Sentinel</h4>
                <p>Complete your participation for <b>12 Mountain Cleanup</b> projects</p>
              </div>
            </div>
          </div>
          <div class="main-card-footer">
            <span>15 Events</span>
            <!-- <button>→</button> -->
          </div>
        </div>
      </a>



      <!-- Card 6 -->
      <a href="/V/router.php?module=projects&action=events&event_type=Coral Restoration#events-section"
        class="card-link">
        <div class="card">

          <h2>Coral Restoration</h2>
          <p>Participate in coral reef rehabilitation projects to restore underwater ecosystems and support marine
            biodiversity.</p>
          <div class="badge-preview">
            <div class="badge-preview-title">Earn this badge:</div>
            <div class="badge-container">
              <div class="badge-icon"><img src="/V/View/projects/E_images/badges/coralrestoration.png"
                  alt="Coral Restoration" />
              </div>
              <div class="badge-info">
                <h4>Coral Guardian</h4>
                <p>Complete your participation for <b>25 Coral Restoration</b> projects</p>
              </div>
            </div>
          </div>
          <div class="main-card-footer">
            <span>12 Events</span>
            <!-- <button>→</button> -->
          </div>
        </div>
      </a>
    </section>


    <!-- Updated Filters Section -->
    <div class="filters-container">
      <form method="GET" action="/V/router.php">
        <input type="hidden" name="module" value="projects">
        <input type="hidden" name="action" value="events">

        <section class="filters">

          <input type="text" name="search" placeholder=" Search events..."
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

          <select class="location-filter" name="location">
            <option value="">All location</option>
            <?php foreach ($locations as $location): ?>
              <option value="<?php echo htmlspecialchars($location); ?>" <?php echo (isset($_GET['location']) && $_GET['location'] == $location) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($location); ?>
              </option>
            <?php endforeach; ?>
          </select>


          <select class="type-filter" name="event_type">

            <option value="">All Types</option>
            <option value="Beach Cleanup" <?= ($_GET['event_type'] ?? '') === 'Beach Cleanup' ? 'selected' : '' ?>>Beach
              Cleanup</option>
            <option value="Tree Planting" <?= ($_GET['event_type'] ?? '') === 'Tree Planting' ? 'selected' : '' ?>>Tree
              Planting</option>
            <option value="Mangrove Restoration" <?= ($_GET['event_type'] ?? '') === 'Mangrove Restoration' ? 'selected' : '' ?>>Mangrove Restoration</option>
            <option value="City Cleanup" <?= ($_GET['event_type'] ?? '') === 'City Cleanup' ? 'selected' : '' ?>>City
              Cleanup</option>
            <option value="Mountain Cleanup" <?= ($_GET['event_type'] ?? '') === 'Mountain Cleanup' ? 'selected' : '' ?>>
              Mountain Cleanup</option>
            <option value="Coral Restoration" <?= ($_GET['event_type'] ?? '') === 'Coral Restoration' ? 'selected' : '' ?>>
              Coral Restoration</option>
          </select>
          <input type="date" class="date-filter" name="date" value="<?= htmlspecialchars($_GET['date'] ?? '') ?>" />



          <button type="submit" class="search-btn">Search</button>

          <button type="button" class="clear-filters-btn" onclick="clearFilters()">✕ Clear</button>


          <!-- <button class="clear-filters-btn">✕ Clear</button> -->
        </section>

    </div>
    <div class="buttoncontainer">
      <button type="submit" class="annual-btn" name="is_annual" value="1">Annual Events</button>
      </form>
      <div>

        <?php if ($role === 'manager' || $role === 'representative'): ?>
          <button onclick="window.location.href='../../../V/router.php?module=projects&action=createevent'"
            class="create-btn">✛ Create Event</button>
        <?php endif; ?>
      </div>

    </div>
    <!-- Events Grid -->
    <section class="event-grid" id="events-section">

      <?php
      $role = $_SESSION['role'] ?? '';
      $today = date('Y-m-d');

      // Filter events if user is volunteer or guest
      if ($role === 'volunteer' || $role === 'sponsor' || $role === 'manager' || $role === 'representative' || $role === 'manager' || $role === 'admin' || $role === 'organisationrep') {
        $events = array_filter($events, function ($event) use ($today) {
          return $event['event_date'] >= $today;
        });
      }
      ?>



      <?php if (!empty($events)): ?>
        <?php foreach ($events as $event): ?>


          <!-- Event Card -->
          <div class="event-card" id="event-<?= $event['event_id'] ?>">

            <!-- <img src="/V/View/projects/E_images/<1?= htmlspecialchars($event['name']) ?>.jpg" alt="Beach Cleanup" /> -->

            <img src="/V/View/projects/E_images/<?= str_replace(' ', '_', htmlspecialchars($event['event_type'])) ?>.jpg"
              alt="<?= htmlspecialchars($event['event_type']) ?>"
              onerror="this.src='/V/View/projects/E_images/default_event.jpg'" />



            <div class="badge"><?= htmlspecialchars($event['event_type']) ?></div>
            <?php if ($role === 'sponsor' && $event['is_annual'] == 1): ?>
              <button class="donate-btn"><a href="/V/router.php?module=sponsorship&action=sendsponsorship&event_id=<?= $event['event_id'] ?>">Sponsor</a></button>
            <?php endif; ?>
            <div class="event-content">
              <h3><?= htmlspecialchars($event['name']) ?></h3>
              <p><?= htmlspecialchars($event['description']) ?></p>
              <ul class="event-details">

                <li>📌<?= htmlspecialchars($event['location']) ?>

                  <?php if (!empty($event['gmap_link'])): ?>
                    <button class="map-btn" onclick="window.open('<?= htmlspecialchars($event['gmap_link']) ?>', '_blank')">
                      View Map
                    </button>
                  <?php endif; ?>
                  <!-- <button class="map-btn" >View Map</button></li> -->
                <li>📅 <?= htmlspecialchars($event['event_date']) ?></li>
                <li>🕓 <?= date('h:i A', strtotime($event['time'])) ?> • <?= htmlspecialchars($event['duration']) ?> hrs
                </li>
                <li>⭐<?= htmlspecialchars($event['starpoints_reward']) ?> Star points</li>
              </ul>
              <div class="participant-info">
                <div class="progress-label">Participants</div>
                <div class="progress-label">
                  <?= htmlspecialchars($event['current_participants']) ?>/<?= htmlspecialchars($event['max_participants']) ?>
                </div>

              </div>
              <!-- <div class="progress-bar"><div class="progress" style="width: 46%"></div></div> -->
              <div class="event-card-footer">



                <?php
                $userId = $_SESSION['user_id'] ?? null;
                $isJoined = $userId ? $eventmodel->isUserJoined($event['event_id'], $userId) : false;
                $spotsAvailable = $event['max_participants'] - $event['current_participants'];

                // NEW: check if event start time has already passed
                $eventDateTime = $event['event_date'] . ' ' . ($event['time'] ?? '07:00:00');
                $isEventTimePast = strtotime($eventDateTime) < time();
                ?>

                <!-- <?php if ($role === 'volunteer'): ?>
                  <button
                    onclick="<?= $isJoined ? 'withdrawEvent(' . $event['event_id'] . ')' : 'showForm(' . $event['event_id'] . ', ' . $spotsAvailable . ')' ?>"
                    class="join-btn">
                    <?= $isJoined ? 'Withdraw' : 'Join Event' ?>
                  </button>
                <?php endif; ?> -->

                  

                <?php if (($role === 'volunteer' || $role === 'representative' || $role === 'organisationrep') && ($event['organizer_id']!=$userId)): ?>
                  <?php if ($isJoined && !$isEventTimePast): ?>

                    <!-- Show Withdraw button if user has joined -->
                    <button onclick="confirmLeaveEvent(<?= $event['event_id'] ?>)" class="join-btn">
                      Withdraw
                    </button>
                  <?php elseif (!$isEventTimePast && $spotsAvailable > 0): ?>
                    <!-- Show Join button only if spots are available -->
                    <button onclick="showForm(<?= $event['event_id'] ?>, <?= $spotsAvailable ?>)" class="join-btn">
                      Join Event
                    </button>
                  <?php elseif(!$isEventTimePast): ?>
                    <!-- Show "Event Full" message when max participants reached -->
                    <button class="join-btn" disabled style="opacity: 0.6; cursor: not-allowed;">
                      Event Full
                    </button>
                  <?php endif; ?>
                <?php endif; ?>


                <?php if ($role === 'manager' || $role === 'representative' || $role === 'organisationrep'): ?>
                  <?php
                  $today = date('Y-m-d');
                  $isPastEvent = $event['event_date'] <= $today;
                  ?>
                  <?php if (!$isPastEvent && ($event['organizer_id'] == $userId)): ?>
                    <div class="edit-delete">
                      <button onclick="showEditForm(<?= $event['event_id'] ?>)" class="edit-btn">
                        <img class=edit src="View\projects\E_images\edit.png" alt="edit">
                      </button>

                      <button class="dlt-btnn" onclick="openModaldelete(<?= $event['event_id'] ?>)">
                        <img class=delete src="View\projects\E_images\delete.png" alt="delete">

                      </button>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>

              </div>
            </div>
          </div>

        <?php endforeach; ?>
      <?php else: ?>
        <p>No events available right now.</p>
      <?php endif; ?>
    </section>

  </main>
  <!-- Success Overlay -->
  <form class="overlay" id="form" method="post" action="/V/router.php?module=projects&action=joinevent">
    <input type="hidden" name="event_id" id="joinEventId" value="">
    <div class="modal">

      <span class="close-btn" onclick="closeModal('form')">&times;</span>
      <h2>Join event</h2>

      <!-- Warning banner -->
      <div class="penalty-warning">

        <p>By joining this event, you agree to the withdrawal penalty policy below. Please read carefully before
          confirming.</p>
      </div>

      <!-- Section heading -->
      <p class="penalty-section-label">Withdrawal &amp; penalty policy</p>

      <!-- Penalty table -->
      <div class="penalty-table-wrapper">
        <table class="penalty-table">
          <thead>
            <tr>
              <th>Withdrawal timing</th>
              <th>Point penalty</th>
            </tr>
          </thead>
          <tbody>
            <tr class="row-Success">
              <td>30+ days before event</td>
              <td><span class="badge-success">No penalty</span></td>
            </tr>

            <tr class="row-amber">
              <td>3 – 29 days before</td>
              <td class="penalty-value">Penalty accumilates +1% per day</td>
            </tr>

            <tr class="row-danger">
              <td> 2 days before the event</td>
              <td>Withdrawal is not allowed</td>
            </tr>
            <tr class="row-danger">
              <td>Absent (no-show)</td>
              <td>27% of allocated points</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Footnote -->
      <p class="penalty-footnote">
        Penalty points are deducted from the level points allocated to this specific event, not your total earned
        points.
      </p>

      <!-- Hidden fields preserved for form submission -->
      <div style="display:none;">
        <input type="radio" name="joinType" value="individual" checked>
        <input type="number" name="participants" id="participants" min="1" max="<?= $spotsAvailable ?>">
      </div>

      <!-- Buttons -->
      <div class="modal-buttons">
        <button type="button" class="btn btn-cancel" onclick="closeModal('form')">Cancel</button>
        <button type="submit" class="btn btn-confirm">I understand, join event</button>
      </div>

    </div>
  </form>




  <!-- editform overlay -->
  <?php if (!empty($events)): ?>
    <?php foreach ($events as $event): ?>

      <div class="overlay" id="editForm_<?= $event['event_id'] ?>">
        <div class="modal2">
          <span class="close-btn" onclick="closeModal('editForm_<?= $event['event_id'] ?>')">&times;</span>
          <h2>Edit Event</h2>
          <form method="POST" action="/V/router.php?module=projects&action=updateevent">

            <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">


            <div class="form-group">
              <label for="editEventName">Event Name:</label>
              <input type="text" id="editEventName_<?= $event['event_id'] ?>" name="name"
                value="<?= htmlspecialchars($event['name']) ?>" required>

            </div>

            <div class="form-group">
              <label for="editEventDescription">Description:</label>
              <textarea id="editEventDescription_<?= $event['event_id'] ?>" name="description"
                required><?= htmlspecialchars($event['description']) ?></textarea>
            </div>

            <div class="form-group">
              <label for="editEventLocation">Location:</label>
              <input type="text" id="editEventLocation_<?= $event['event_id'] ?>" name="location"
                value="<?= htmlspecialchars($event['location']) ?>" required>
            </div>

            <div class="form-group">
              <label for="editEventDate">Date:</label>
              <input type="date" id="editEventDate_<?= $event['event_id'] ?>" name="event_date"
                value="<?= htmlspecialchars($event['event_date']) ?>" required>
            </div>
            <div class="form-group">
              <label for="editEventTime">Time:</label>
              <input type="time" id="editEventTime_<?= $event['event_id'] ?>" name="time"
                value="<?= htmlspecialchars($event['time'] ?? '07:00:00') ?>" required>
            </div>

            <div class="form-group">
              <label for="editEventType">Event Type:</label>
              <select id="editEventType" name="event_type" required>
                <option value="">Select Type</option>
                <option value="Beach Cleanup">Beach Cleanup</option>
                <option value="Tree Planting">Tree Planting</option>
                <option value="Mangrove Restoration">Mangrove Restoration</option>
                <option value="City Cleanup">City Cleanup</option>
                <option value="Mountain Cleanup">Mountain Cleanup</option>
                <option value="Coral Restoration">Coral Restoration</option>
              </select>
            </div>

            <div class="form-group">
              <label for="editStarPoints">Star Points Reward:</label>
              <input type="number" id="editStarPoints_<?= $event['event_id'] ?>" name="starpoints_reward"
                value="<?= htmlspecialchars($event['starpoints_reward']) ?>" min="1" required>
            </div>

            <div class="form-group">
              <label for="editMaxParticipants">Maximum Participants:</label>
              <input type="number" id="editMaxParticipants_<?= $event['event_id'] ?>" name="max_participants"
                value="<?= htmlspecialchars($event['max_participants']) ?>" min="1" required>
            </div>


            <div class="modal-buttons">
              <button type="reset" class="btn btn-cancel" onclick="closeModal('editForm')">Cancel</button>
              <button type="submit" class="btn btn-confirm" onclick="saveEventChanges()">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>


  <div class="modal-overlay" id="modalOverlay">
    <div class="modaldelete">
      <div class="icon-container">
        <div class="warning-icon">!</div>
      </div>

      <h2>Delete Event?</h2>

      <div class="modal-text">
        Are you sure you want to delete this event ? This action cannot be undone.</span>
      </div>

      <div class="button-group">
        <!-- <button class="cancel-btn" onclick="closeModaldelete()">Cancel</button>
        <button onclick="confirmDelete()"
          onclick="window.location.href='../../../V/router.php?module=projects&action=deleteevent&id=<?= $event['event_id'] ?>'"
          class="dlt-btn">Delete</button> -->

        <button class="cancel-btn" onclick="closeModaldelete()">Cancel</button>
        <button onclick="confirmDelete()" class="dlt-btn">Delete</button>


        <!-- <button class="delete-btn" onclick="confirmDelete()">Delete</button> -->
      </div>
    </div>
  </div>

  <div class="withdraw-overlay" id="withdrawOverlay">
    <div class="modal" id="modal"></div>
  </div>

  <script src="/V/View/common/commonleave.js"></script>
  <script src="/V/View/projects/events.js"></script>

</body>


</html>