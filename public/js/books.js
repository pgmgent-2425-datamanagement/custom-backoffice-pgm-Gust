// Books management JavaScript functionality

/**
 * Export books data to CSV format
 */
function exportToCSV() {
  // Get books data from the page
  const books = window.booksData || [];

  if (books.length === 0) {
    alert("No books to export");
    return;
  }

  // Create CSV content
  let csv = "Title,Description,Published Year,ISBN\n";

  books.forEach((book) => {
    csv += `"${book.title || ""}","${book.description || ""}","${
      book.published_year || ""
    }","${book.isbn || ""}"\n`;
  });

  // Create and download the file
  const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = `books_export_${new Date().toISOString().split("T")[0]}.csv`;
  a.click();
  window.URL.revokeObjectURL(url);
}

/**
 * Initialize books page functionality
 */
document.addEventListener("DOMContentLoaded", function () {
  // Add event listeners for export button if it exists
  const exportBtn = document.getElementById("exportBtn");
  if (exportBtn) {
    exportBtn.addEventListener("click", exportToCSV);
  }
});
