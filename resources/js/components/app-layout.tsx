import React from 'react';
import { AppShell } from '@/components/app-shell';

interface AppLayoutProps {
    children: React.ReactNode;
}

export { AppLayout };

function AppLayout({ children }: AppLayoutProps) {
    return (
        <AppShell>
            {children}
        </AppShell>
    );
}