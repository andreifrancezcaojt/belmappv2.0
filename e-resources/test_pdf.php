<div class="container">
  <div class="row">
    <div class="col">
      <form class="needs-validation" id="form" enctype="multipart/form-data" novalidate>
        <center>
          <h2 class="mb-4">Add E-Resources</h2>
        </center>
        <hr>

        <div class="form-group">
          <label for="pdf" class="form-label">Choose a file to upload (Only PDF format allowed):</label>
          <input type="file" class="form-control" id="pdf" name="pdf" required>
          <div class="invalid-feedback">Please choose a file.</div>
        </div>

        <div class="form-group">
          <label for="pdf_name" class="form-label">E-Resource name:</label>
          <input type="text" class="form-control" id="pdf_name" name="pdf_name" required>
          <div class="invalid-feedback">Please enter e-resource name.</div>
        </div>

        <div class="form-group">
          <label for="pdf_callnumber" class="form-label">Call No:</label>
          <input type="text" class="form-control" id="pdf_callnumber" name="pdf_callnumber" required>
          <div class="invalid-feedback">Please enter call number.</div>
        </div>

        <div class="form-group">
          <label for="category" class="form-label">Select PDF category:</label>
          <select class="form-control" id="category" name="category" required>
            <option value="" disabled selected>Select a category</option>

            <option value="General Works">a. General Works</option>
            <option value="Philosophy, Psychology & Religion">b. Philosophy, Psychology & Religion</option>
            <option value="General Works">c. Auxiliary Science of History</option>
            <option value="World History  & History of Europe, Asia, Africa, Australia, New Zealand, etc.">d. World History & History of Europe, Asia, Africa, Australia, New Zealand, etc.</option>
            <option value="History of Americas">e. History of Americas</option>

            <option value="History of Americas (US, British, Dutch, French, & Latin America)">f. History of Americas (US, British, Dutch, French, & Latin America)</option>
            <option value="Geography, Anthropology & Recreation">g. Geography, Anthropology & Recreation</option>
            <option value="Social Science">h. Social Science</option>
            <option value="Political Science">j. Political Science</option>
            <option value="Law">k. Law</option>

            <option value="Education">l. Education</option>
            <option value="Music & Books on Music">m. Music & Books on Music</option>
            <option value="Fine Arts">n. Fine Arts</option>
            <option value="Language & Literatures">p. Language & Literatures</option>
            <option value="Science">q. Science</option>

            <option value="Medicine">r. Medicine</option>
            <option value="Agriculture">s. Agriculture</option>
            <option value="Technology">t. Technology</option>
            <option value="Military Science">u. Military Science</option>

            <option value="Naval Science">v. Naval Science</option>
            <option value="Bibliography, Library Science & Information Resource (General)">z. Bibliography, Library Science & Information Resource (General)</option>

          </select>
          <div class="invalid-feedback">Please choose a category.</div>
        </div><br>

        <div class="form-group">
          <button type="button" onclick="upload_pdf()" class="btn btn-info btn-sm">Upload PDF</button>
        </div>
      </form>
    </div>
  </div>
</div>