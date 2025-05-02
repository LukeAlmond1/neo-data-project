import { useState } from 'react';
import axios, { AxiosResponse } from 'axios';
import { Head, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import {
    Select,
    SelectTrigger,
    SelectValue,
    SelectContent,
    SelectItem,
} from '@/components/ui/select';
import { PageProps as InertiaPageProps } from '@inertiajs/core';

type ViewType = 'NeoObjects' | 'NeoObjectAnalysis';

interface PageProps extends InertiaPageProps {
    analysis?: {
        data: AnalysisEntry[];
    };
}

interface CloseApproach {
    id: number;
    close_approach_date_full: string;
    relative_velocity: number;
    miss_distance: number;
}

interface NeoObject {
    reference_id: string;
    name: string;
    absolute_magnitude: number;
    estimated_diameter_min: number;
    estimated_diameter_max: number;
    is_hazardous: boolean;
    close_approaches: CloseApproach[];
}

interface AnalysisEntry {
    id: number;
    analysis_date: string;
    total_neo_count: number;
    avg_estimated_diameter_min: number;
    avg_estimated_diameter_max: number;
    max_velocity: number;
    min_miss_distance: number;
}

interface PageProps {
    analysis?: {
        data: AnalysisEntry[];
    };
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
];

export default function Dashboard() {
    const { props } = usePage<PageProps>();
    const [viewType, setViewType] = useState<ViewType>('NeoObjects');
    const [startDate, setStartDate] = useState('');
    const [endDate, setEndDate] = useState('');
    const [searchId, setSearchId] = useState('');
    const [neoResult, setNeoResult] = useState<NeoObject | null>(null);
    const [analysisData, setAnalysisData] = useState<AnalysisEntry[]>(props.analysis?.data ?? []);

    const searchNeoById = async () => {
        if (!searchId) return;

        try {
            const res: AxiosResponse<{ data: NeoObject }> = await axios.get(`/neo-objects/${searchId}`);
            setNeoResult(res.data.data);
        } catch {
            setNeoResult(null);
        }
    };

    const filterByDateRange = async () => {
        if (!startDate || !endDate) return;

        try {
            const res: AxiosResponse<{ data: AnalysisEntry[] }> = await axios.get('/neo-analysis', {
                params: { start_date: startDate, end_date: endDate },
            });

            setAnalysisData(res.data.data);
        } catch (error) {
            setAnalysisData([]);
            console.error('Failed to fetch filtered analysis:', error);
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex flex-col gap-4 rounded-xl p-4 w-full">
                <div className="grid gap-4 max-w-xl">
                    <div className="space-y-2">
                        <Label htmlFor="viewType">Select view</Label>
                        <Select value={viewType} onValueChange={(val) => setViewType(val as ViewType)}>
                            <SelectTrigger id="viewType">
                                <SelectValue placeholder="Select view" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="NeoObjects">NeoObjects</SelectItem>
                                <SelectItem value="NeoObjectAnalysis">NeoObjectAnalysis</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>

                    {viewType === 'NeoObjects' && (
                        <div className="grid grid-cols-[1fr_auto] items-end gap-2">
                            <div className="space-y-2">
                                <Label htmlFor="search-id">Search by Reference ID</Label>
                                <Input
                                    id="search-id"
                                    value={searchId}
                                    onChange={(e) => setSearchId(e.target.value)}
                                    placeholder="Enter NEO reference ID..."
                                />
                            </div>
                            <Button className="mt-6" onClick={searchNeoById}>
                                Search
                            </Button>
                        </div>
                    )}

                    {viewType === 'NeoObjectAnalysis' && (
                        <div className="grid grid-cols-[1fr_1fr_auto] items-end gap-4">
                            <div className="space-y-2">
                                <Label htmlFor="start-date">Start date</Label>
                                <Input
                                    id="start-date"
                                    type="date"
                                    value={startDate}
                                    onChange={(e) => setStartDate(e.target.value)}
                                />
                            </div>
                            <div className="space-y-2">
                                <Label htmlFor="end-date">End date</Label>
                                <Input
                                    id="end-date"
                                    type="date"
                                    value={endDate}
                                    onChange={(e) => setEndDate(e.target.value)}
                                />
                            </div>
                            <Button className="mt-6" onClick={filterByDateRange}>
                                Filter
                            </Button>
                        </div>
                    )}
                </div>

                {viewType === 'NeoObjects' && neoResult && (
                    <Card className="mt-6 p-4 w-full">
                        <h2 className="text-lg font-semibold mb-2">NEO: {neoResult.name}</h2>
                        <table className="w-full text-sm border border-border">
                            <thead className="bg-muted text-foreground">
                            <tr>
                                <th className="p-2 text-left">Reference ID</th>
                                <th className="p-2 text-left">Magnitude</th>
                                <th className="p-2 text-left">Diameter Min</th>
                                <th className="p-2 text-left">Diameter Max</th>
                                <th className="p-2 text-left">Hazardous</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr className="border-t border-border">
                                <td className="p-2">{neoResult.reference_id}</td>
                                <td className="p-2">{neoResult.absolute_magnitude}</td>
                                <td className="p-2">{neoResult.estimated_diameter_min}</td>
                                <td className="p-2">{neoResult.estimated_diameter_max}</td>
                                <td className="p-2">{neoResult.is_hazardous ? 'Yes' : 'No'}</td>
                            </tr>
                            </tbody>
                        </table>

                        <h3 className="text-md font-medium mt-4">Close Approaches</h3>
                        <table className="w-full text-sm border border-border">
                            <thead className="bg-muted text-foreground">
                            <tr>
                                <th className="p-2 text-left">Date</th>
                                <th className="p-2 text-left">Velocity (m/s)</th>
                                <th className="p-2 text-left">Miss Distance (m)</th>
                            </tr>
                            </thead>
                            <tbody>
                            {neoResult.close_approaches.map((approach) => (
                                <tr key={approach.id} className="border-t border-border">
                                    <td className="p-2">{approach.close_approach_date_full}</td>
                                    <td className="p-2">{approach.relative_velocity}</td>
                                    <td className="p-2">{approach.miss_distance}</td>
                                </tr>
                            ))}
                            </tbody>
                        </table>
                    </Card>
                )}

                {viewType === 'NeoObjectAnalysis' && (
                    <Card className="mt-6 p-4 w-full overflow-x-auto">
                        <h2 className="text-lg font-semibold mb-4">NEO Data Analysis</h2>
                        <table className="w-full text-sm border border-border">
                            <thead className="bg-muted text-foreground">
                            <tr>
                                <th className="p-2 text-left">Date</th>
                                <th className="p-2 text-left">NEO Count</th>
                                <th className="p-2 text-left">Avg Diameter Min</th>
                                <th className="p-2 text-left">Avg Diameter Max</th>
                                <th className="p-2 text-left">Max Velocity</th>
                                <th className="p-2 text-left">Min Miss Distance</th>
                            </tr>
                            </thead>
                            {analysisData.length > 0 && (
                                <tbody>
                                {analysisData.map((entry) => (
                                    <tr key={entry.id} className="border-t border-border">
                                        <td className="p-2">{entry.analysis_date}</td>
                                        <td className="p-2">{entry.total_neo_count}</td>
                                        <td className="p-2">{entry.avg_estimated_diameter_min}</td>
                                        <td className="p-2">{entry.avg_estimated_diameter_max}</td>
                                        <td className="p-2">{entry.max_velocity}</td>
                                        <td className="p-2">{entry.min_miss_distance}</td>
                                    </tr>
                                ))}
                                </tbody>
                            )}
                        </table>
                    </Card>
                )}
            </div>
        </AppLayout>
    );
}
