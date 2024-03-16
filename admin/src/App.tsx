import { For, JSXElement } from "solid-js";
import { Card, CardContent, CardDescription } from "~/components/ui/card";
import { CardFooter, CardHeader, CardTitle } from "~/components/ui/card";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "~/components/ui/tabs";

import CouponList from "~/tabs/CouponList";
import Options from "~/tabs/Options";

type TTab = {
    name: string;
    value: string;
    content: JSXElement;
};

const tabs: TTab[] = [
    {
        name: "Coupon List",
        value: "coupon-list",
        content: <CouponList />,
    },
    {
        name: "Options",
        value: "options",
        content: <Options />,
    },
];

const App = () => {
    const name = "Wordpress Plugin Template";

    return (
        <Card>
            <CardHeader>
                <CardTitle>{name} Settings</CardTitle>
                <CardDescription>Manage all of your setting for {name}</CardDescription>
            </CardHeader>
            <CardContent class="min-h-[76vh]">
                <Tabs defaultValue={tabs[0].value}>
                    <TabsList class="flex w-full">
                        <For each={tabs}>
                            {tab => (
                                <TabsTrigger value={tab.value} class="w-full">
                                    {tab.name}
                                </TabsTrigger>
                            )}
                        </For>
                    </TabsList>
                    <For each={tabs}>
                        {tab => <TabsContent value={tab.value}>{tab.content}</TabsContent>}
                    </For>
                </Tabs>
            </CardContent>
            <CardFooter>
                <div>
                    Build with ❤️ by{" "}
                    <a href="https://developershihab.com" class="underline">
                        Shihab Mahamud
                    </a>
                </div>
            </CardFooter>
        </Card>
    );
};

export default App;
