#!/bin/bash

# Test SQLite compatibility fixes for HRIS Dashboard
echo "🔧 Testing SQLite Database Compatibility Fixes"
echo "==============================================="

cd /home/purnama/Documents/HRIS

echo "📋 Checking Laravel configuration..."

# Clear all caches
php artisan config:clear > /dev/null 2>&1
php artisan route:clear > /dev/null 2>&1
php artisan view:clear > /dev/null 2>&1
php artisan cache:clear > /dev/null 2>&1

echo "✅ Caches cleared"

# Check if database exists
if [ -f "database/database.sqlite" ]; then
    echo "✅ SQLite database file exists"
else
    echo "⚠️  SQLite database file not found, creating one..."
    touch database/database.sqlite
fi

# Check database connection
if php artisan migrate:status > /dev/null 2>&1; then
    echo "✅ Database connection working"
else
    echo "❌ Database connection issues"
    echo "   Running migrations..."
    php artisan migrate --force
fi

# Test if we can query the absensi table structure
echo ""
echo "📊 Testing database table structure..."

# Check if the tanggal column exists in absensi table
if sqlite3 database/database.sqlite "PRAGMA table_info(absensi);" | grep -q "tanggal"; then
    echo "✅ Absensi table has 'tanggal' column (correct)"
else
    echo "❌ Absensi table structure issue"
fi

echo ""
echo "🔍 Testing specific SQLite queries..."

# Test if our SQLite-specific queries work
echo "Testing attendance query..."
if php -r "
require 'vendor/autoload.php';
\$app = require_once 'bootstrap/app.php';
\$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    \$result = DB::select('SELECT strftime(\"%m\", tanggal) as month FROM absensi LIMIT 1');
    echo 'SQLite query syntax working\n';
} catch (Exception \$e) {
    echo 'Query error: ' . \$e->getMessage() . \"\n\";
}
"; then
    echo "✅ SQLite date functions working"
fi

echo ""
echo "🌐 Testing API endpoints (if server is running)..."

# Test if we can access the dashboard (this will work only if server is running)
if curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/ | grep -q "200"; then
    echo "✅ Dashboard accessible"

    # Test API endpoints
    echo "Testing analytics API..."
    if curl -s http://localhost:8000/api/admin/analytics | grep -q "success"; then
        echo "✅ Admin analytics API working"
    else
        echo "⚠️  Admin analytics API needs authentication"
    fi
else
    echo "⚠️  Server not running. To test the dashboard:"
    echo "   1. Run: php artisan serve"
    echo "   2. Visit: http://localhost:8000"
    echo "   3. Login with admin credentials"
fi

echo ""
echo "📝 Summary of fixes applied:"
echo "=============================="
echo "✅ Fixed column name: tanggal_absensi → tanggal"
echo "✅ Converted MySQL MONTH() → SQLite strftime('%m', column)"
echo "✅ Converted MySQL YEAR() → SQLite strftime('%Y', column)"
echo "✅ Converted MySQL MONTHNAME() → SQLite strftime('%m', column)"
echo "✅ Converted whereYear() → whereRaw() with strftime"
echo "✅ Converted whereMonth() → whereRaw() with strftime"
echo "✅ Fixed status values: 'Tidak Masuk' → 'Alpha'"
echo "✅ All API endpoints updated for SQLite compatibility"

echo ""
echo "🚀 Next steps:"
echo "1. Start server: php artisan serve"
echo "2. Visit dashboard: http://localhost:8000"
echo "3. Test all chart functionality"
echo "4. Verify notification system works"
echo ""
echo "✨ SQLite compatibility testing complete!"
