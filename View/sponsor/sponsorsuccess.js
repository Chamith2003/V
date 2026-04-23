
        function downloadReceipt() {
            // Generate receipt text content
            const receiptText = `
════════════════════════════════════════════════════════════
                    DONATION RECEIPT
                  Volunteer Organization
════════════════════════════════════════════════════════════

Transaction Information
────────────────────────────────────────────────────────────
Transaction ID:      #TXN-2024-10789
Date & Time:         October 23, 2025 at 02:45 PM
Payment Method:      Mastercard •••• 4242
Status:              ✓ Completed

════════════════════════════════════════════════════════════
                  TOTAL DONATION AMOUNT
                      LKR 1,000
════════════════════════════════════════════════════════════

Thank You For Your Generous Contribution!

This receipt confirms your donation has been processed 
successfully. Your support makes a real difference in our 
mission.

For questions or concerns, please contact us at:
v4volunteering@gmail.com

Generated on: October 23, 2025
════════════════════════════════════════════════════════════
            `;

            // Create a blob with the text content
            const blob = new Blob([receiptText], { type: 'text/plain' });
            
            // Create download link
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'Donation_Receipt_TXN-2024-10789.txt';
            
            // Trigger download
            document.body.appendChild(a);
            a.click();
            
            // Cleanup
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        }
    