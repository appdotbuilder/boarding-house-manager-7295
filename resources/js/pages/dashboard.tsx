import { AppLayout } from '@/components/app-layout';
import { Head, Link } from '@inertiajs/react';

interface DashboardProps {
    stats: {
        total_boarding_houses: number;
        total_rooms: number;
        occupied_rooms: number;
        vacant_rooms: number;
        total_tenants: number;
        current_month_bills: number;
        current_month_income: number;
        pending_bills: number;
        overdue_bills: number;
    };
    recentBills: Array<{
        id: number;
        invoice_number: string;
        amount: number;
        status: string;
        room_assignment?: {
            tenant?: {
                first_name: string;
                last_name: string;
            };
        };
    }>;
    recentTenants: Array<{
        id: number;
        first_name: string;
        last_name: string;
        email: string;
        active_assignment?: {
            room?: {
                room_number: string;
            };
        };
    }>;
    [key: string]: unknown;
}

export default function Dashboard({ stats, recentBills, recentTenants }: DashboardProps) {
    return (
        <AppLayout>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-4 overflow-x-auto">
                {/* Statistics Cards */}
                <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div className="rounded-xl border border-sidebar-border/70 bg-card p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-muted-foreground">Boarding Houses</p>
                                <p className="text-2xl font-bold">{stats.total_boarding_houses}</p>
                            </div>
                            <div className="text-3xl">🏢</div>
                        </div>
                    </div>

                    <div className="rounded-xl border border-sidebar-border/70 bg-card p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-muted-foreground">Total Rooms</p>
                                <p className="text-2xl font-bold">{stats.total_rooms}</p>
                                <p className="text-xs text-green-600">
                                    {stats.occupied_rooms} occupied • {stats.vacant_rooms} vacant
                                </p>
                            </div>
                            <div className="text-3xl">🏠</div>
                        </div>
                    </div>

                    <div className="rounded-xl border border-sidebar-border/70 bg-card p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-muted-foreground">Active Tenants</p>
                                <p className="text-2xl font-bold">{stats.total_tenants}</p>
                            </div>
                            <div className="text-3xl">👥</div>
                        </div>
                    </div>

                    <div className="rounded-xl border border-sidebar-border/70 bg-card p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-muted-foreground">Monthly Income</p>
                                <p className="text-2xl font-bold">₱{stats.current_month_income?.toLocaleString() || 0}</p>
                                <p className="text-xs text-muted-foreground">
                                    {stats.current_month_bills} bills this month
                                </p>
                            </div>
                            <div className="text-3xl">💰</div>
                        </div>
                    </div>
                </div>

                {/* Quick Actions */}
                <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <Link
                        href="/boarding-houses/create"
                        className="rounded-xl border border-sidebar-border/70 bg-card p-4 hover:bg-accent transition-colors"
                    >
                        <div className="text-center">
                            <div className="text-2xl mb-2">➕</div>
                            <p className="font-medium">Add Boarding House</p>
                        </div>
                    </Link>

                    <Link
                        href="/tenants/create"
                        className="rounded-xl border border-sidebar-border/70 bg-card p-4 hover:bg-accent transition-colors"
                    >
                        <div className="text-center">
                            <div className="text-2xl mb-2">👤</div>
                            <p className="font-medium">Add Tenant</p>
                        </div>
                    </Link>

                    <Link
                        href="/bills"
                        className="rounded-xl border border-sidebar-border/70 bg-card p-4 hover:bg-accent transition-colors"
                    >
                        <div className="text-center">
                            <div className="text-2xl mb-2">📋</div>
                            <p className="font-medium">View Bills</p>
                            {stats.pending_bills > 0 && (
                                <p className="text-xs text-orange-600">{stats.pending_bills} pending</p>
                            )}
                        </div>
                    </Link>

                    <Link
                        href="/reports"
                        className="rounded-xl border border-sidebar-border/70 bg-card p-4 hover:bg-accent transition-colors"
                    >
                        <div className="text-center">
                            <div className="text-2xl mb-2">📊</div>
                            <p className="font-medium">Reports</p>
                        </div>
                    </Link>
                </div>

                {/* Recent Activity */}
                <div className="grid gap-4 md:grid-cols-2">
                    <div className="rounded-xl border border-sidebar-border/70 bg-card p-6">
                        <h3 className="text-lg font-semibold mb-4">Recent Bills</h3>
                        {recentBills && recentBills.length > 0 ? (
                            <div className="space-y-3">
                                {recentBills.map((bill) => (
                                    <div key={bill.id} className="flex items-center justify-between p-3 bg-accent rounded-lg">
                                        <div>
                                            <p className="font-medium">{bill.invoice_number}</p>
                                            <p className="text-sm text-muted-foreground">
                                                {bill.room_assignment?.tenant?.first_name} {bill.room_assignment?.tenant?.last_name}
                                            </p>
                                        </div>
                                        <div className="text-right">
                                            <p className="font-medium">₱{bill.amount}</p>
                                            <p className={`text-xs px-2 py-1 rounded-full ${
                                                bill.status === 'paid' ? 'bg-green-100 text-green-800' :
                                                bill.status === 'overdue' ? 'bg-red-100 text-red-800' :
                                                'bg-yellow-100 text-yellow-800'
                                            }`}>
                                                {bill.status}
                                            </p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <p className="text-muted-foreground">No recent bills</p>
                        )}
                    </div>

                    <div className="rounded-xl border border-sidebar-border/70 bg-card p-6">
                        <h3 className="text-lg font-semibold mb-4">Recent Tenants</h3>
                        {recentTenants && recentTenants.length > 0 ? (
                            <div className="space-y-3">
                                {recentTenants.map((tenant) => (
                                    <div key={tenant.id} className="flex items-center justify-between p-3 bg-accent rounded-lg">
                                        <div>
                                            <p className="font-medium">{tenant.first_name} {tenant.last_name}</p>
                                            <p className="text-sm text-muted-foreground">{tenant.email}</p>
                                        </div>
                                        <div className="text-right">
                                            <p className="text-sm">
                                                {tenant.active_assignment?.room?.room_number 
                                                    ? `Room ${tenant.active_assignment.room.room_number}` 
                                                    : 'No room assigned'}
                                            </p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <p className="text-muted-foreground">No recent tenants</p>
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
