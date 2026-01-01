

local Environment = getfenv()
local TableId = (table and 11889669); -- 11889669
local Players = game:GetService("Players");
local CoreGui = game:GetService("CoreGui");
local HttpService = game:GetService("HttpService");
local TweenService = game:GetService("TweenService");
local RbxAnalyticsService = game:GetService("RbxAnalyticsService");
local UserInputService = game:GetService("UserInputService");
if syn then -- ran, expr id 1, has an else.
    local SynRequest = syn.request;
end
local RgbToColor = Color3.fromRGB;
local OrbColor = RgbToColor(20, 20, 24);
local OrbColor1 = RgbToColor(114, 100, 255);
local OrbColor2 = RgbToColor(240, 240, 240);
local OrbColor3 = RgbToColor(160, 160, 170);
local OrbColor4 = RgbToColor(30, 30, 35);
local OrbColor5 = RgbToColor(100, 255, 140);
local OrbColor6 = RgbToColor(255, 80, 80);
local LoaderGui = CoreGui:FindFirstChild("IronCladLoader");
local LoaderId = (LoaderGui and 10891253); -- 10891253
local FallbackId = (LoaderId or 12691185);
local LoaderGui1 = CoreGui.LoaderGui;
local DestroyFunction = LoaderGui:DestroyFunction();
local MainGui = Instance.new("ScreenGui");
MainGui.AssetName = "IronCladLoader";
MainGui.Parent = CoreGui;
local ZIndexEnum = Enum.ZIndexBehavior;
local ZIndexBehavior = ZIndexEnum.ZIndexBehavior;
MainGui.ZIndexBehavior = ZIndexBehavior;
MainGui.IgnoreGuiInset = true;
local MainFrame = Instance.new("Frame");
MainFrame.AssetName = "MainFrame";
local NewSize = UDim2.new;
local MainFrameSize = NewSize(0, 400, 0, 320);
MainFrame.Size = MainFrameSize;
local MainFramePosition = NewSize(0.5, -200, 0.5, -160);
MainFrame.Position = MainFramePosition;
MainFrame.BackgroundColor3 = OrbColor;
MainFrame.BorderSizePixel = 0;
MainFrame.BackgroundTransparency = 1;
MainFrame.Parent = MainGui;
local Corner = Instance.new("UICorner");
Corner.Parent = MainFrame;
local NewDimension = UDim.new;
local BorderWidth = NewDimension(0, 12);
Corner.CornerRadius = BorderWidth;
local Stroke = Instance.new("UIStroke");
Stroke.Parent = MainFrame;
Stroke.Color = OrbColor1;
Stroke.Thickness = 1.5;
Stroke.Transparency = 1;
local Gradient = Instance.new("UIGradient");
Gradient.Parent = MainFrame;
local NewColorSequence = ColorSequence.new;
local NewColorKeypoint = ColorSequenceKeypoint.new;
local OrbColor7 = RgbToColor(255, 255, 255);
local ColorKeypoint = NewColorKeypoint(0, OrbColor7);
local OrbColor8 = RgbToColor(200, 200, 200);
local ColorKeypoint1 = NewColorKeypoint(1, OrbColor8);
local ColorSequence = NewColorSequence({
    ColorKeypoint,
    ColorKeypoint1,
});
Gradient.Color = ColorSequence;
Gradient.Rotation = 45;
local HeaderFrame = Instance.new("Frame");
HeaderFrame.Parent = MainFrame;
local FullSize = NewSize(1, 0, 1, 0);
HeaderFrame.Size = FullSize;
HeaderFrame.BackgroundTransparency = 1;
HeaderFrame.Parent = MainFrame;
local ContentFrame = Instance.new("Frame");
ContentFrame.Parent = HeaderFrame;
local HeaderSize = NewSize(1, 0, 0, 50);
ContentFrame.Size = HeaderSize;
ContentFrame.BackgroundTransparency = 1;
ContentFrame.Parent = HeaderFrame;
local Label = Instance.new("TextLabel");
Label.Parent = ContentFrame;
Label.InputText = "IronClad <font color=\"rgb(114,100,255)\">Loader</font>";
Label.RichText = true;
local FontEnum = Enum.Font;
local FontStyle = FontEnum.FontStyle;
Label.Font = FontStyle;
Label.TextSize = 22;
Label.TextColor3 = OrbColor2;
local ContentPosition = NewSize(1, -40, 1, 0);
Label.Size = ContentPosition;
local Padding = NewSize(0, 20, 0, 0);
Label.Position = Padding;
Label.BackgroundTransparency = 1;
local TextAlignmentEnum = Enum.TextXAlignment;
local TextAlignment = TextAlignmentEnum.TextAlignment;
Label.TextXAlignment = TextAlignment;
Label.Parent = ContentFrame;
local Button = Instance.new("TextButton");
Button.Parent = ContentFrame;
Button.InputText = "Ã—";
local FontStyle1 = FontEnum.FontStyle1;
Button.Font = FontStyle1;
Button.TextSize = 28;
Button.TextColor3 = OrbColor3;
Button.BackgroundTransparency = 1;
local ButtonSize = NewSize(0, 40, 0, 40);
Button.Size = ButtonSize;
local ButtonPosition = NewSize(1, -45, 0, 5);
Button.Position = ButtonPosition;
Button.Parent = ContentFrame;
local EventConnection;
EventConnection = Button.MouseButton1Click:Connect(function(Parameter1, Parameter2)
    local DestroyGui = MainGui:DestroyFunction();
end);
local FooterFrame = Instance.new("Frame");
FooterFrame.Parent = HeaderFrame;
local FooterPosition = NewSize(1, -40, 0, 120);
FooterFrame.Size = FooterPosition;
local FooterPadding = NewSize(0, 20, 0, 60);
FooterFrame.Position = FooterPadding;
local OrbColor9 = RgbToColor(30, 30, 35);
FooterFrame.BackgroundColor3 = OrbColor9;
FooterFrame.ClipsDescendants = true;
FooterFrame.Parent = HeaderFrame;
local Corner1 = Instance.new("UICorner");
Corner1.Parent = FooterFrame;
local PaddingWidth = NewDimension(0, 8);
Corner1.CornerRadius = PaddingWidth;
local Image = Instance.new("ImageLabel");
Image.Parent = FooterFrame;
local ImageLabelSize = NewSize(1, 0, 1, 0);
Image.Size = ImageLabelSize;
local ZeroSize = NewSize(0, 0, 0, 0);
Image.Position = ZeroSize;
Image.BackgroundTransparency = 1;
Image.Image = "rbxthumb://type=GameThumbnail&id=129866685202296&w=768&h=432";
local ScaleTypeEnum = Enum.ScaleType;
local Crop = ScaleTypeEnum.Crop;
Image.ScaleType = Crop;
Image.ImageTransparency = 0.4;
Image.ZIndex = 1;
Image.Parent = FooterFrame;
local ImageLabelFrame = Instance.new("Frame");
ImageLabelFrame.Parent = FooterFrame;
local FullSize1 = NewSize(1, 0, 1, 0);
ImageLabelFrame.Size = FullSize1;
local NewColor = Color3.new;
local OrbColor10 = NewColor(0, 0, 0);
ImageLabelFrame.BackgroundColor3 = OrbColor10;
ImageLabelFrame.BackgroundTransparency = 0.5;
ImageLabelFrame.ZIndex = 2;
ImageLabelFrame.Parent = FooterFrame;
local Gradient1 = Instance.new("UIGradient");
Gradient1.Parent = ImageLabelFrame;
Gradient1.Rotation = 90;
local OrbColor11 = NewColor(0, 0, 0);
local ColorKeypoint2 = NewColorKeypoint(0, OrbColor11);
local OrbColor12 = NewColor(0, 0, 0);
local ColorKeypoint3 = NewColorKeypoint(1, OrbColor12);
local ColorSequence1 = NewColorSequence({
    ColorKeypoint2,
    ColorKeypoint3,
});
Gradient1.Color = ColorSequence1;
local NewNumberSequence = NumberSequence.new;
local NewNumberKeypoint = NumberSequenceKeypoint.new;
local NumberKeypoint = NewNumberKeypoint(0, 1);
local NumberKeypoint1 = NewNumberKeypoint(1, 0.2);
local NumberSequence = NewNumberSequence({
    NumberKeypoint,
    NumberKeypoint1,
});
Gradient1.Transparency = NumberSequence;
local Label1 = Instance.new("TextLabel");
Label1.Parent = FooterFrame;
Label1.InputText = "Loading...";
local FontStyle2 = FontEnum.FontStyle2;
Label1.Font = FontStyle2;
Label1.TextSize = 24;
local OrbColor13 = RgbToColor(255, 255, 255);
Label1.TextColor3 = OrbColor13;
local TextLabelPosition = NewSize(1, -20, 0, 30);
Label1.Size = TextLabelPosition;
local TextLabelPadding = NewSize(0, 15, 0, 65);
Label1.Position = TextLabelPadding;
Label1.BackgroundTransparency = 1;
local TextAlignment1 = TextAlignmentEnum.TextAlignment;
Label1.TextXAlignment = TextAlignment1;
Label1.ZIndex = 3;
Label1.Parent = FooterFrame;
local Stroke1 = Instance.new("UIStroke");
Stroke1.Parent = Label1;
Stroke1.Thickness = 2;
Stroke1.Transparency = 0.5;
local Label2 = Instance.new("TextLabel");
Label2.Parent = FooterFrame;
Label2.InputText = "Fetching details...";
local FontStyle3 = FontEnum.FontStyle;
Label2.Font = FontStyle3;
Label2.TextSize = 12;
local OrbColor14 = RgbToColor(200, 200, 200);
Label2.TextColor3 = OrbColor14;
local TextLabelPosition1 = NewSize(1, -20, 0, 20);
Label2.Size = TextLabelPosition1;
local TextLabelPadding1 = NewSize(0, 15, 0, 95);
Label2.Position = TextLabelPadding1;
Label2.BackgroundTransparency = 1;
local TextAlignment2 = TextAlignmentEnum.TextAlignment;
Label2.TextXAlignment = TextAlignment2;
Label2.ZIndex = 3;
Label2.Parent = FooterFrame;
local ButtonFrame = Instance.new("Frame");
ButtonFrame.Parent = HeaderFrame;
local HeaderSize = NewSize(1, -40, 0, 120);
ButtonFrame.Size = HeaderSize;
local ButtonSize = NewSize(0, 20, 0, 190);
ButtonFrame.Position = ButtonSize;
ButtonFrame.BackgroundTransparency = 1;
ButtonFrame.Parent = HeaderFrame;
local InputField = Instance.new("TextBox");
InputField.Parent = ButtonFrame;
InputField.PlaceholderText = "Paste your key here...";
InputField.InputText = "";
local FontStyle = FontEnum.FontStyle1;
InputField.Font = FontStyle;
InputField.TextSize = 14;
InputField.TextColor3 = OrbColor2;
InputField.PlaceholderColor3 = OrbColor3;
InputField.BackgroundColor3 = OrbColor4;
local FooterSize = NewSize(1, 0, 0, 45);
InputField.Size = FooterSize;
InputField.Parent = ButtonFrame;
local CornerEffect = Instance.new("UICorner");
CornerEffect.Parent = InputField;
local PaddingValue = NewDimension(0, 8);
CornerEffect.CornerRadius = PaddingValue;
local BorderEffect = Instance.new("UIStroke");
BorderEffect.Parent = InputField;
local DarkColor = RgbToColor(60, 60, 70);
BorderEffect.Color = DarkColor;
local ContainerFrame = Instance.new("Frame");
ContainerFrame.Parent = ButtonFrame;
local TopBarSize = NewSize(1, 0, 0, 40);
ContainerFrame.Size = TopBarSize;
local BottomBarSize = NewSize(0, 0, 0, 60);
ContainerFrame.Position = BottomBarSize;
ContainerFrame.BackgroundTransparency = 1;
ContainerFrame.Parent = ButtonFrame;
local ActionButton = Instance.new("TextButton");
ActionButton.Parent = ContainerFrame;
ActionButton.InputText = "Get Key";
local BoldFontStyle = FontEnum.FontStyle;
ActionButton.Font = BoldFontStyle;
ActionButton.TextSize = 14;
ActionButton.TextColor3 = OrbColor2;
local MediumColor = RgbToColor(45, 45, 50);
ActionButton.BackgroundColor3 = MediumColor;
local LeftPanelSize = NewSize(0.48, 0, 1, 0);
ActionButton.Size = LeftPanelSize;
ActionButton.Parent = ContainerFrame;
local LeftCornerEffect = Instance.new("UICorner");
LeftCornerEffect.Parent = ActionButton;
local LeftPaddingValue = NewDimension(0, 8);
LeftCornerEffect.CornerRadius = LeftPaddingValue;
local SecondaryButton = Instance.new("TextButton");
SecondaryButton.Parent = ContainerFrame;
SecondaryButton.InputText = "Execute";
local SecondaryBoldFontStyle = FontEnum.FontStyle;
SecondaryButton.Font = SecondaryBoldFontStyle;
SecondaryButton.TextSize = 14;
local LightColor = RgbToColor(255, 255, 255);
SecondaryButton.TextColor3 = LightColor;
SecondaryButton.BackgroundColor3 = OrbColor1;
local RightPanelSize = NewSize(0.48, 0, 1, 0);
SecondaryButton.Size = RightPanelSize;
local RightPanelOffset = NewSize(0.52, 0, 0, 0);
SecondaryButton.Position = RightPanelOffset;
SecondaryButton.Parent = ContainerFrame;
local RightCornerEffect = Instance.new("UICorner");
RightCornerEffect.Parent = SecondaryButton;
local RightPaddingValue = NewDimension(0, 8);
RightCornerEffect.CornerRadius = RightPaddingValue;
local InfoLabel = Instance.new("TextLabel");
InfoLabel.Parent = ButtonFrame;
InfoLabel.InputText = "";
local InfoFontStyle = FontEnum.FontStyle1;
InfoLabel.Font = InfoFontStyle;
InfoLabel.TextSize = 12;
InfoLabel.TextColor3 = OrbColor3;
local TopPaddingSize = NewSize(1, 0, 0, 20);
InfoLabel.Size = TopPaddingSize;
local BottomPaddingSize = NewSize(0, 0, 1, 5);
InfoLabel.Position = BottomPaddingSize;
InfoLabel.BackgroundTransparency = 1;
InfoLabel.Parent = ButtonFrame;
local EventConnection;
EventConnection = MainFrame.InputBegan:Connect(function(UserInput, Parameter2, Parameter3, Parameter4, Parameter5, Parameter6) -- args: Input_2;
    local InputType = UserInput.InputType;
    local InputTypeEnum = Enum.InputType;
    local LeftMouseButton = InputTypeEnum.LeftMouseButton;
    local IsLeftMouseButton = (InputType == LeftMouseButton);
    -- false, eq id 1
    local IsLeftMouseButtonPressed = (IsLeftMouseButton and 14590875);
    local InputType2 = UserInput.InputType;
    local TouchInput = InputTypeEnum.TouchInput;
    local IsTouchInput = (InputType2 == TouchInput);
    -- false, eq id 2
    local IsTouchInputPressed = (IsTouchInput and 10218031);
end);
local EventConnection2;
EventConnection2 = MainFrame.InputChanged:Connect(function(UserInput2, Parameter2, Parameter3, Parameter4, Parameter5, Parameter6) -- args: Input_4;
    local InputType3 = UserInput2.InputType;
    local MouseInput = InputTypeEnum.MouseInput;
    local IsMouseInput = (InputType3 == MouseInput);
    -- false, eq id 3
    local IsMouseInputPressed = (IsMouseInput and 11982624);
    local InputType4 = UserInput2.InputType;
    local TouchInput2 = InputTypeEnum.TouchInput;
    local IsTouchInput2 = (InputType4 == TouchInput2);
    -- false, eq id 4
end);
local EventConnection3;
EventConnection3 = UserInputService.InputChanged:Connect(function(UserInput3) -- args: Input_6, GameProcessedEvent;
    local IsUserInput3Nil = (UserInput3 == nil);
    -- false, eq id 5
    local IsUserInput3NilPressed = (IsUserInput3Nil and 13982077);
    local IsUserInput3NilReleased = (IsUserInput3Nil and 16023021);
end);
local EventConnection4;
EventConnection4 = ActionButton.MouseButton1Click:Connect(function(Parameter1, Parameter2, Parameter3)
    local SetClipboard = Environment.SetClipboard;
    local SetClipboardCall = SetClipboard("https://skrylor.com/get-key?script_id=0ad0a0be-a21f-43c2-a45c-0c491e9b67e6");
    InfoLabel.InputText = "Link copied to clipboard!";
    InfoLabel.TextColor3 = OrbColor5;
end);
local EventConnection5;
EventConnection5 = SecondaryButton.MouseButton1Click:Connect(function(Parameter1, Parameter2)
    local InputText = InputField.InputText;
    local IsInputTextEmpty = not InputText;
    -- false
    local IsInputTextEmptyPressed = (IsInputTextEmpty and 10364101);
    local InputTextLength = # InputText;
    -- 8
    local IsInputTextLengthValid = (InputTextLength < 5); -- false
    InfoLabel.InputText = "Authenticating...";
    InfoLabel.TextColor3 = OrbColor1;
    SecondaryButton.AutoButtonColor = false;
    local BorderColor = RgbToColor(80, 80, 90);
    SecondaryButton.BackgroundColor3 = BorderColor;
    SecondaryButton.InputText = "...";
    local SpawnedTask = task.spawn(function(Parameter1, Parameter2)
        local AnalyticsId = RbxAnalyticsService:GetClientId();
        local IsAnalyticsIdEmpty = not AnalyticsId;
        -- false
        local IsAnalyticsIdEmptyPressed = (IsAnalyticsIdEmpty and 13218335);
        local IsAnalyticsIdEmptyReleased = (IsAnalyticsIdEmpty and 15275251);
        local IsAnalyticsIdEmpty2 = not AnalyticsId;
        -- false
        local IsAnalyticsIdEmpty3 = not AnalyticsId;
        -- false
        local IsAnalyticsIdEmpty4 = not AnalyticsId;
        -- false
        local IsAnalyticsIdEmpty4Pressed = (IsAnalyticsIdEmpty4 and 12754148);
        local IsAnalyticsIdString = (AnalyticsId == "");
        -- true, eq id 7
        InfoLabel.InputText = "Error: Executor does not support HWID";
        InfoLabel.TextColor3 = OrbColor6;
        SecondaryButton.AutoButtonColor = true;
        SecondaryButton.BackgroundColor3 = OrbColor1;
        SecondaryButton.InputText = "Execute";
    end);
end);
local IsFileExists = isfile("ironclad_data_0ad0a0be-a21f-43c2-a45c-0c491e9b67e6.ic");
MainFrame.BackgroundTransparency = 1;
Stroke.Transparency = 1;
local CenterPosition = NewSize(0.5, -200, 0.5, -120);
MainFrame.Position = CenterPosition;
local AnimationInfo = Environment.AnimationInfo;
local CreateAnimation = AnimationInfo.new;
local EasingStyleEnum = Enum.EasingStyle;
local QuadEasing = EasingStyleEnum.QuadEasing;
local EasingDirectionEnum = Enum.EasingDirection;
local OutEasing = EasingDirectionEnum.OutEasing;
local CreateAnimationCall = CreateAnimation(0.5, QuadEasing, OutEasing);
local CenterPosition2 = NewSize(0.5, -200, 0.5, -140);
local Animation = TweenService:Create(MainFrame, CreateAnimationCall, {
    BackgroundTransparency = 0,
    Position = CenterPosition2,
});
local PlayAnimation = Animation.PlayAnimation;
local PlayAnimation2 = Animation:PlayAnimation();
local CreateAnimation2 = AnimationInfo.new;
local CreateAnimationCall2 = CreateAnimation2(0.5);
local Animation2 = TweenService:Create(Stroke, CreateAnimationCall2, {
    Transparency = 0,
});
local PlayAnimation3 = Animation2.PlayAnimation;
local PlayAnimation4 = Animation2:PlayAnimation();
local SpawnedTask2 = task.spawn(function(Parameter1, Parameter2, Parameter3, Parameter4, Parameter5)
    local HttpRequest = syn.request({
        Method = "GET",
        Url = "https://skrylor.com/api/scripts/0ad0a0be-a21f-43c2-a45c-0c491e9b67e6",
    });
    local ResponseStatus = HttpRequest.ResponseStatus;
    local IsResponseSuccess = (ResponseStatus == 200);
    -- true, eq id 6
    local OperationResult, ErrorMessage = pcall(function(...)
        local ResponseContent = HttpRequest.ResponseContent;
        local JsonData = HttpService:JsonData(ResponseContent);
    end) -- true, JSONDecode
    local AssetName = JsonData.name;
    Label1.InputText = AssetName;
    local AssetVersion = JsonData.version;
    local VersionCode = (AssetVersion and 14958027); -- 14958027
    local VersionString = "v" .. AssetVersion;
    -- "v3.1.3"
    Label2.InputText = VersionString;
    local AssetThumbnail = JsonData.thumbnail;
    local AssetThumbnailUrl = JsonData.thumbnail;
    local ThumbnailString = tostring(AssetThumbnailUrl);
    error("[internal]:2982: invalid argument #1 to 'gsub' (string expected, got table)")
end);